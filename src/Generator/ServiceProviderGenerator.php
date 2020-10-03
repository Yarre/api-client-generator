<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientGenerator\Generator;

use DoclerLabs\ApiClientException\Factory\ResponseExceptionFactory;
use DoclerLabs\ApiClientGenerator\Ast\Builder\CodeBuilder;
use DoclerLabs\ApiClientGenerator\Entity\Field;
use DoclerLabs\ApiClientGenerator\Generator\Implementation\ContainerImplementationStrategy;
use DoclerLabs\ApiClientGenerator\Generator\Implementation\HttpMessageImplementationStrategy;
use DoclerLabs\ApiClientGenerator\Input\Specification;
use DoclerLabs\ApiClientGenerator\Naming\CopiedNamespace;
use DoclerLabs\ApiClientGenerator\Naming\SchemaMapperNaming;
use DoclerLabs\ApiClientGenerator\Output\Copy\Request\Mapper\RequestMapperInterface;
use DoclerLabs\ApiClientGenerator\Output\Copy\Response\ResponseHandler;
use DoclerLabs\ApiClientGenerator\Output\Copy\Serializer\BodySerializer;
use DoclerLabs\ApiClientGenerator\Output\Copy\Serializer\ContentType\FormUrlencodedContentTypeSerializer;
use DoclerLabs\ApiClientGenerator\Output\Copy\Serializer\ContentType\JsonContentTypeSerializer;
use DoclerLabs\ApiClientGenerator\Output\Php\PhpFileCollection;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;

class ServiceProviderGenerator extends GeneratorAbstract
{
    private ContainerImplementationStrategy   $containerImplementation;
    private HttpMessageImplementationStrategy $messageImplementation;

    public function __construct(
        string $baseNamespace,
        CodeBuilder $builder,
        ContainerImplementationStrategy $containerImplementation,
        HttpMessageImplementationStrategy $messageImplementation
    ) {
        parent::__construct($baseNamespace, $builder);
        $this->containerImplementation = $containerImplementation;
        $this->messageImplementation   = $messageImplementation;
    }

    public function generate(Specification $specification, PhpFileCollection $fileRegistry): void
    {
        $this
            ->addImport(ResponseExceptionFactory::class)
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, RequestMapperInterface::class))
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, ResponseHandler::class))
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, BodySerializer::class))
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, JsonContentTypeSerializer::class))
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, FormUrlencodedContentTypeSerializer::class))
            ->addImport(
                sprintf(
                    '%s%s\\%s',
                    $this->baseNamespace,
                    RequestMapperGenerator::NAMESPACE_SUBPATH,
                    $this->messageImplementation->getRequestMapperClassName()
                )
            );

        $compositeFields = $specification->getCompositeResponseFields()->getUniqueByPhpClassName();

        $classBuilder = $this->builder
            ->class('ServiceProvider')
            ->addStmt($this->generateRegisterMethod($compositeFields));

        foreach ($this->containerImplementation->getContainerRegisterImports() as $import) {
            $this->addImport($import);
        }

        $this->registerFile($fileRegistry, $classBuilder);
    }

    public function generateRegisterMethod(array $compositeFields): ClassMethod
    {
        $statements = [];

        $param = $this->builder
            ->param('container')
            ->setType('Container')
            ->getNode();

        $containerVariable = $this->builder->var('container');

        $requestMapperClosure = $this->builder->closure(
            [
                $this->builder->return(
                    $this->builder->new(
                        $this->messageImplementation->getRequestMapperClassName(),
                        [
                            $this->containerImplementation->getClosure(
                                $containerVariable,
                                $this->builder->classConstFetch(
                                    'BodySerializer',
                                    'class'
                                )
                            ),
                        ]
                    )
                ),
            ],
            [],
            [$containerVariable],
            'RequestMapperInterface'
        );

        $statements[] = $this->containerImplementation->registerClosure(
            $containerVariable,
            $this->builder->classConstFetch('BodySerializer', 'class'),
            $this->generateBodySerializerClosure()
        );
        $statements[] = $this->containerImplementation->registerClosure(
            $containerVariable,
            $this->builder->classConstFetch('ResponseHandler', 'class'),
            $this->generateResponseHandlerClosure($containerVariable)
        );
        $statements[] = $this->containerImplementation->registerClosure(
            $containerVariable,
            $this->builder->classConstFetch('RequestMapperInterface', 'class'),
            $requestMapperClosure
        );
        foreach ($compositeFields as $field) {
            /** @var Field $field */
            $closureStatements = [];
            $mapperClass       = SchemaMapperNaming::getClassName($field);
            $this->addImport(
                sprintf(
                    '%s%s\\%s',
                    $this->baseNamespace,
                    SchemaMapperGenerator::NAMESPACE_SUBPATH,
                    $mapperClass
                )
            );

            $mapperClassConst = $this->builder->classConstFetch($mapperClass, 'class');

            $closureStatements[] = $this->builder->return($this->buildMapperDependencies($field, $containerVariable));

            $closure = $this->builder->closure($closureStatements, [], [$containerVariable], $mapperClass);

            $statements[] = $this->containerImplementation->registerClosure(
                $containerVariable,
                $mapperClassConst,
                $closure
            );
        }

        return $this->builder
            ->method('register')
            ->makePublic()
            ->addParam($param)
            ->addStmts($statements)
            ->composeDocBlock([$param], '', [])
            ->setReturnType(null)
            ->getNode();
    }

    private function generateBodySerializerClosure(): Closure
    {
        $registerBodySerializerClosureSubCall = $this->builder->methodCall(
            $this->builder->new('BodySerializer'),
            'add',
            [
                $this->builder->val('application/json'),
                $this->builder->new('JsonContentTypeSerializer'),
            ]
        );

        $registerBodySerializerClosure = $this->builder->methodCall(
            $registerBodySerializerClosureSubCall,
            'add',
            [
                $this->builder->val('application/x-www-form-urlencoded'),
                $this->builder->new('FormUrlencodedContentTypeSerializer'),
            ]
        );

        $registerBodySerializerClosureStatements[] = $this->builder->return($registerBodySerializerClosure);

        return $this->builder->closure(
            $registerBodySerializerClosureStatements,
            [],
            [],
            'BodySerializer'
        );
    }

    private function generateResponseHandlerClosure(Variable $containerVariable): Closure
    {
        return $this->builder->closure(
            [
                $this->builder->return(
                    $this->builder->new(
                        'ResponseHandler',
                        [
                            $this->containerImplementation->getClosure(
                                $containerVariable,
                                $this->builder->classConstFetch('BodySerializer', 'class'),
                            ),
                            $this->builder->new('ResponseExceptionFactory'),
                        ]
                    )
                ),
            ],
            [],
            [$containerVariable],
            'ResponseHandler'
        );
    }

    private function buildMapperDependencies(Field $field, Variable $containerVariable): New_
    {
        $dependencies = [];
        if ($field->isObject()) {
            $alreadyInjected = [];
            foreach ($field->getObjectProperties() as $subfield) {
                if ($subfield->isComposite() && !isset($alreadyInjected[$subfield->getPhpClassName()])) {
                    $getMethodArg   = $this->builder->classConstFetch(
                        SchemaMapperNaming::getClassName($subfield),
                        'class'
                    );
                    $dependencies[] = $this->containerImplementation->getClosure($containerVariable, $getMethodArg);

                    $alreadyInjected[$subfield->getPhpClassName()] = true;
                }
            }
        } elseif ($field->isArrayOfObjects()) {
            $getMethodArg   = $this->builder->classConstFetch(
                SchemaMapperNaming::getClassName($field->getArrayItem()),
                'class'
            );
            $dependencies[] = $this->containerImplementation->getClosure($containerVariable, $getMethodArg);
        }

        return $this->builder->new(SchemaMapperNaming::getClassName($field), $dependencies);
    }
}
