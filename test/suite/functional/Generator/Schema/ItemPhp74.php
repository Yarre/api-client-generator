<?php declare(strict_types=1);

/*
 * This file was generated by docler-labs/api-client-generator.
 *
 * Do not edit it manually.
 */

namespace Test\Schema;

use DateTimeInterface;
use DoclerLabs\ApiClientException\RequestValidationException;
use JsonSerializable;

class Item implements SerializableInterface, JsonSerializable
{
    public const MANDATORY_ENUM_ONE_OPTION = 'one option';

    public const MANDATORY_ENUM_ANOTHER_OPTION = 'another option';

    public const OPTIONAL_ENUM_ONE_OPTION = 'one option';

    public const OPTIONAL_ENUM_ANOTHER_OPTION = 'another option';

    private int $mandatoryInteger;

    private string $mandatoryString;

    private string $mandatoryEnum;

    private DateTimeInterface $mandatoryDate;

    private ?DateTimeInterface $mandatoryNullableDate = null;

    private float $mandatoryFloat;

    private bool $mandatoryBoolean;

    private array $mandatoryArray;

    private array $mandatoryArrayWithMinItems;

    private ItemMandatoryObject $mandatoryObject;

    private $mandatoryMixed;

    private $mandatoryAnyOf;

    private ?ItemNullableObject $nullableObject = null;

    private ?DateTimeInterface $nullableDate = null;

    private ?int $optionalInteger = null;

    private ?string $optionalString = null;

    private ?string $optionalEnum = null;

    private ?DateTimeInterface $optionalDate = null;

    private ?float $optionalFloat = null;

    private ?bool $optionalBoolean = null;

    private ?array $optionalArray = null;

    private ?array $optionalMixedArray = null;

    private ?array $optionalArrayWithMinMaxItems = null;

    private ?string $optionalStringWithMinMaxLength = null;

    private ?string $optionalStringWithPattern = null;

    private ?int $optionalIntegerBetweenIncluded = null;

    private ?int $optionalIntegerBetweenExcluded = null;

    private ?float $optionalNumberBetweenIncluded = null;

    private ?float $optionalNumberBetweenExcluded = null;

    private ?EmbeddedObject $optionalObject = null;

    /**
     * @param string[] $mandatoryArray
     * @param string[] $mandatoryArrayWithMinItems
     *
     * @throws RequestValidationException
     */
    public function __construct(int $mandatoryInteger, string $mandatoryString, string $mandatoryEnum, DateTimeInterface $mandatoryDate, ?DateTimeInterface $mandatoryNullableDate, float $mandatoryFloat, bool $mandatoryBoolean, array $mandatoryArray, array $mandatoryArrayWithMinItems, ItemMandatoryObject $mandatoryObject, $mandatoryMixed, $mandatoryAnyOf)
    {
        $this->mandatoryInteger      = $mandatoryInteger;
        $this->mandatoryString       = $mandatoryString;
        $this->mandatoryEnum         = $mandatoryEnum;
        $this->mandatoryDate         = $mandatoryDate;
        $this->mandatoryNullableDate = $mandatoryNullableDate;
        $this->mandatoryFloat        = $mandatoryFloat;
        $this->mandatoryBoolean      = $mandatoryBoolean;
        $this->mandatoryArray        = $mandatoryArray;
        if (\count($mandatoryArrayWithMinItems) < 1) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Expected min items: `1`.', 'mandatoryArrayWithMinItems', $mandatoryArrayWithMinItems));
        }
        $this->mandatoryArrayWithMinItems = $mandatoryArrayWithMinItems;
        $this->mandatoryObject            = $mandatoryObject;
        $this->mandatoryMixed             = $mandatoryMixed;
        $this->mandatoryAnyOf             = $mandatoryAnyOf;
    }

    public function setNullableObject(?ItemNullableObject $nullableObject): self
    {
        $this->nullableObject = $nullableObject;

        return $this;
    }

    public function setNullableDate(?DateTimeInterface $nullableDate): self
    {
        $this->nullableDate = $nullableDate;

        return $this;
    }

    public function setOptionalInteger(int $optionalInteger): self
    {
        $this->optionalInteger = $optionalInteger;

        return $this;
    }

    public function setOptionalString(string $optionalString): self
    {
        $this->optionalString = $optionalString;

        return $this;
    }

    public function setOptionalEnum(string $optionalEnum): self
    {
        $this->optionalEnum = $optionalEnum;

        return $this;
    }

    public function setOptionalDate(DateTimeInterface $optionalDate): self
    {
        $this->optionalDate = $optionalDate;

        return $this;
    }

    public function setOptionalFloat(float $optionalFloat): self
    {
        $this->optionalFloat = $optionalFloat;

        return $this;
    }

    public function setOptionalBoolean(bool $optionalBoolean): self
    {
        $this->optionalBoolean = $optionalBoolean;

        return $this;
    }

    /**
     * @param string[] $optionalArray
     */
    public function setOptionalArray(array $optionalArray): self
    {
        $this->optionalArray = $optionalArray;

        return $this;
    }

    /**
     * @param mixed[] $optionalMixedArray
     */
    public function setOptionalMixedArray(array $optionalMixedArray): self
    {
        $this->optionalMixedArray = $optionalMixedArray;

        return $this;
    }

    /**
     * @param string[] $optionalArrayWithMinMaxItems
     *
     * @throws RequestValidationException
     */
    public function setOptionalArrayWithMinMaxItems(array $optionalArrayWithMinMaxItems): self
    {
        if (\count($optionalArrayWithMinMaxItems) < 1) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Expected min items: `1`.', 'optionalArrayWithMinMaxItems', $optionalArrayWithMinMaxItems));
        }
        if (\count($optionalArrayWithMinMaxItems) > 5) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Expected max items: `5`.', 'optionalArrayWithMinMaxItems', $optionalArrayWithMinMaxItems));
        }
        $this->optionalArrayWithMinMaxItems = $optionalArrayWithMinMaxItems;

        return $this;
    }

    /**
     * @throws RequestValidationException
     */
    public function setOptionalStringWithMinMaxLength(string $optionalStringWithMinMaxLength): self
    {
        if (\strlen($optionalStringWithMinMaxLength) < 1) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Length should be greater than 1.', 'optionalStringWithMinMaxLength', $optionalStringWithMinMaxLength));
        }
        if (\strlen($optionalStringWithMinMaxLength) > 5) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Length should be less than 5.', 'optionalStringWithMinMaxLength', $optionalStringWithMinMaxLength));
        }
        $this->optionalStringWithMinMaxLength = $optionalStringWithMinMaxLength;

        return $this;
    }

    /**
     * @throws RequestValidationException
     */
    public function setOptionalStringWithPattern(string $optionalStringWithPattern): self
    {
        if (\preg_match('/^\\d{3}-\\d{2}-\\d{4}$/', $optionalStringWithPattern) !== 1) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Pattern is ^\\d{3}-\\d{2}-\\d{4}$.', 'optionalStringWithPattern', $optionalStringWithPattern));
        }
        $this->optionalStringWithPattern = $optionalStringWithPattern;

        return $this;
    }

    /**
     * @throws RequestValidationException
     */
    public function setOptionalIntegerBetweenIncluded(int $optionalIntegerBetweenIncluded): self
    {
        if ($optionalIntegerBetweenIncluded < 0) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be less than 0.', 'optionalIntegerBetweenIncluded', $optionalIntegerBetweenIncluded));
        }
        if ($optionalIntegerBetweenIncluded > 5) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be greater than 5.', 'optionalIntegerBetweenIncluded', $optionalIntegerBetweenIncluded));
        }
        $this->optionalIntegerBetweenIncluded = $optionalIntegerBetweenIncluded;

        return $this;
    }

    /**
     * @throws RequestValidationException
     */
    public function setOptionalIntegerBetweenExcluded(int $optionalIntegerBetweenExcluded): self
    {
        if ($optionalIntegerBetweenExcluded <= 0) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be less than or equal to 0.', 'optionalIntegerBetweenExcluded', $optionalIntegerBetweenExcluded));
        }
        if ($optionalIntegerBetweenExcluded >= 5) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be greater than or equal to 5.', 'optionalIntegerBetweenExcluded', $optionalIntegerBetweenExcluded));
        }
        $this->optionalIntegerBetweenExcluded = $optionalIntegerBetweenExcluded;

        return $this;
    }

    /**
     * @throws RequestValidationException
     */
    public function setOptionalNumberBetweenIncluded(float $optionalNumberBetweenIncluded): self
    {
        if ($optionalNumberBetweenIncluded < 0.0) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be less than 0.', 'optionalNumberBetweenIncluded', $optionalNumberBetweenIncluded));
        }
        if ($optionalNumberBetweenIncluded > 5.0) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be greater than 5.', 'optionalNumberBetweenIncluded', $optionalNumberBetweenIncluded));
        }
        $this->optionalNumberBetweenIncluded = $optionalNumberBetweenIncluded;

        return $this;
    }

    /**
     * @throws RequestValidationException
     */
    public function setOptionalNumberBetweenExcluded(float $optionalNumberBetweenExcluded): self
    {
        if ($optionalNumberBetweenExcluded <= 0.0) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be less than or equal to 0.', 'optionalNumberBetweenExcluded', $optionalNumberBetweenExcluded));
        }
        if ($optionalNumberBetweenExcluded >= 5.0) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be greater than or equal to 5.', 'optionalNumberBetweenExcluded', $optionalNumberBetweenExcluded));
        }
        $this->optionalNumberBetweenExcluded = $optionalNumberBetweenExcluded;

        return $this;
    }

    public function setOptionalObject(EmbeddedObject $optionalObject): self
    {
        $this->optionalObject = $optionalObject;

        return $this;
    }

    public function getMandatoryInteger(): int
    {
        return $this->mandatoryInteger;
    }

    public function getMandatoryString(): string
    {
        return $this->mandatoryString;
    }

    public function getMandatoryEnum(): string
    {
        return $this->mandatoryEnum;
    }

    public function getMandatoryDate(): DateTimeInterface
    {
        return $this->mandatoryDate;
    }

    public function getMandatoryNullableDate(): ?DateTimeInterface
    {
        return $this->mandatoryNullableDate;
    }

    public function getMandatoryFloat(): float
    {
        return $this->mandatoryFloat;
    }

    public function getMandatoryBoolean(): bool
    {
        return $this->mandatoryBoolean;
    }

    /**
     * @return string[]
     */
    public function getMandatoryArray(): array
    {
        return $this->mandatoryArray;
    }

    /**
     * @return string[]
     */
    public function getMandatoryArrayWithMinItems(): array
    {
        return $this->mandatoryArrayWithMinItems;
    }

    public function getMandatoryObject(): ItemMandatoryObject
    {
        return $this->mandatoryObject;
    }

    public function getMandatoryMixed()
    {
        return $this->mandatoryMixed;
    }

    public function getMandatoryAnyOf()
    {
        return $this->mandatoryAnyOf;
    }

    public function getNullableObject(): ?ItemNullableObject
    {
        return $this->nullableObject;
    }

    public function getNullableDate(): ?DateTimeInterface
    {
        return $this->nullableDate;
    }

    public function getOptionalInteger(): ?int
    {
        return $this->optionalInteger;
    }

    public function getOptionalString(): ?string
    {
        return $this->optionalString;
    }

    public function getOptionalEnum(): ?string
    {
        return $this->optionalEnum;
    }

    public function getOptionalDate(): ?DateTimeInterface
    {
        return $this->optionalDate;
    }

    public function getOptionalFloat(): ?float
    {
        return $this->optionalFloat;
    }

    public function getOptionalBoolean(): ?bool
    {
        return $this->optionalBoolean;
    }

    /**
     * @return string[]|null
     */
    public function getOptionalArray(): ?array
    {
        return $this->optionalArray;
    }

    /**
     * @return mixed[]|null
     */
    public function getOptionalMixedArray(): ?array
    {
        return $this->optionalMixedArray;
    }

    /**
     * @return string[]|null
     */
    public function getOptionalArrayWithMinMaxItems(): ?array
    {
        return $this->optionalArrayWithMinMaxItems;
    }

    public function getOptionalStringWithMinMaxLength(): ?string
    {
        return $this->optionalStringWithMinMaxLength;
    }

    public function getOptionalStringWithPattern(): ?string
    {
        return $this->optionalStringWithPattern;
    }

    public function getOptionalIntegerBetweenIncluded(): ?int
    {
        return $this->optionalIntegerBetweenIncluded;
    }

    public function getOptionalIntegerBetweenExcluded(): ?int
    {
        return $this->optionalIntegerBetweenExcluded;
    }

    public function getOptionalNumberBetweenIncluded(): ?float
    {
        return $this->optionalNumberBetweenIncluded;
    }

    public function getOptionalNumberBetweenExcluded(): ?float
    {
        return $this->optionalNumberBetweenExcluded;
    }

    public function getOptionalObject(): ?EmbeddedObject
    {
        return $this->optionalObject;
    }

    public function toArray(): array
    {
        $fields                               = [];
        $fields['mandatoryInteger']           = $this->mandatoryInteger;
        $fields['mandatoryString']            = $this->mandatoryString;
        $fields['mandatoryEnum']              = $this->mandatoryEnum;
        $fields['mandatoryDate']              = $this->mandatoryDate->format(DATE_RFC3339);
        $fields['mandatoryNullableDate']      = $this->mandatoryNullableDate !== null ? $this->mandatoryNullableDate->format(DATE_RFC3339) : null;
        $fields['mandatoryFloat']             = $this->mandatoryFloat;
        $fields['mandatoryBoolean']           = $this->mandatoryBoolean;
        $fields['mandatoryArray']             = $this->mandatoryArray;
        $fields['mandatoryArrayWithMinItems'] = $this->mandatoryArrayWithMinItems;
        $fields['mandatoryObject']            = $this->mandatoryObject->toArray();
        $fields['mandatoryMixed']             = $this->mandatoryMixed;
        $fields['mandatoryAnyOf']             = $this->mandatoryAnyOf;
        $fields['nullableObject']             = $this->nullableObject !== null ? $this->nullableObject->toArray() : null;
        $fields['nullableDate']               = $this->nullableDate   !== null ? $this->nullableDate->format(DATE_RFC3339) : null;
        if ($this->optionalInteger !== null) {
            $fields['optionalInteger'] = $this->optionalInteger;
        }
        if ($this->optionalString !== null) {
            $fields['optionalString'] = $this->optionalString;
        }
        if ($this->optionalEnum !== null) {
            $fields['optionalEnum'] = $this->optionalEnum;
        }
        if ($this->optionalDate !== null) {
            $fields['optionalDate'] = $this->optionalDate->format(DATE_RFC3339);
        }
        if ($this->optionalFloat !== null) {
            $fields['optionalFloat'] = $this->optionalFloat;
        }
        if ($this->optionalBoolean !== null) {
            $fields['optionalBoolean'] = $this->optionalBoolean;
        }
        if ($this->optionalArray !== null) {
            $fields['optionalArray'] = $this->optionalArray;
        }
        if ($this->optionalMixedArray !== null) {
            $fields['optionalMixedArray'] = $this->optionalMixedArray;
        }
        if ($this->optionalArrayWithMinMaxItems !== null) {
            $fields['optionalArrayWithMinMaxItems'] = $this->optionalArrayWithMinMaxItems;
        }
        if ($this->optionalStringWithMinMaxLength !== null) {
            $fields['optionalStringWithMinMaxLength'] = $this->optionalStringWithMinMaxLength;
        }
        if ($this->optionalStringWithPattern !== null) {
            $fields['optionalStringWithPattern'] = $this->optionalStringWithPattern;
        }
        if ($this->optionalIntegerBetweenIncluded !== null) {
            $fields['optionalIntegerBetweenIncluded'] = $this->optionalIntegerBetweenIncluded;
        }
        if ($this->optionalIntegerBetweenExcluded !== null) {
            $fields['optionalIntegerBetweenExcluded'] = $this->optionalIntegerBetweenExcluded;
        }
        if ($this->optionalNumberBetweenIncluded !== null) {
            $fields['optionalNumberBetweenIncluded'] = $this->optionalNumberBetweenIncluded;
        }
        if ($this->optionalNumberBetweenExcluded !== null) {
            $fields['optionalNumberBetweenExcluded'] = $this->optionalNumberBetweenExcluded;
        }
        if ($this->optionalObject !== null) {
            $fields['optionalObject'] = $this->optionalObject->toArray();
        }

        return $fields;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
