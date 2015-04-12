<?php
namespace Kyoya\DateTime;

class DateTimeFormatter implements FormatterInterface
{

    /**
     * Mapping of the supported formats.
     *
     * @var array
     */
    protected $supportedFormats = array(
        'none'   => \IntlDateFormatter::NONE,
        'short'  => \IntlDateFormatter::SHORT,
        'medium' => \IntlDateFormatter::MEDIUM,
        'long'   => \IntlDateFormatter::LONG,
        'full'   => \IntlDateFormatter::FULL,
    );

    /**
     * Locale to use for formatting a date and/or a time.
     *
     * @var string
     */
    private $locale;

    /**
     * Initializes the new instance. Sets the locale.
     *
     * @param string $locale Locale to use.
     *
     * @return DateTimeFormatter
     */
    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Formats the date and time of a DateTime object using the locale specific default date and time format.
     *
     * @param \DateTimeInterface $dateTime Object to format.
     *
     * @return string
     */
    public function format(\DateTimeInterface $dateTime)
    {
        $timezone  = $this->extractTimezone($dateTime);
        $formatter = $this->createFormatter($timezone);

        return $this->realFormat($formatter, $dateTime);
    }

    /**
     * Formats the date of a DateTime object using the specified format.
     *
     * @param \DateTimeInterface $dateTime      Object to format.
     * @param string             $desiredFormat Date format to use.
     *
     * @return string
     */
    public function formatDate(\DateTimeInterface $dateTime, $desiredFormat)
    {
        if (!isset($this->supportedFormats[$desiredFormat])) {
            throw $this->createUnknownFormatException($desiredFormat);
        }

        $timezone = $this->extractTimezone($dateTime);

        $dateType = $this->supportedFormats[$desiredFormat];

        $formatter = $this->createFormatter($timezone, $dateType, $this->supportedFormats['none']);

        return $this->realFormat($formatter, $dateTime);
    }

    /**
     * Formats the time of a DateTime object using the specified format.
     *
     * @param \DateTimeInterface $dateTime      Object to format.
     * @param string             $desiredFormat Time format to use.
     *
     * @return string
     */
    public function formatTime(\DateTimeInterface $dateTime, $desiredFormat)
    {
        if (!isset($this->supportedFormats[$desiredFormat])) {
            throw $this->createUnknownFormatException($desiredFormat);
        }

        $timezone = $this->extractTimezone($dateTime);

        $timeType = $this->supportedFormats[$desiredFormat];

        $formatter = $this->createFormatter($timezone, $this->supportedFormats['none'], $timeType);

        return $this->realFormat($formatter, $dateTime);
    }

    /**
     * Formats the date and the time of a DateTime object using the specified formats.
     *
     * @param \DateTimeInterface $dateTime          Object to format.
     * @param string             $desiredDateFormat Date format to use.
     * @param string             $desiredTimeFormat Time format to use.
     *
     * @return string
     */
    public function formatDateTime(\DateTimeInterface $dateTime, $desiredDateFormat, $desiredTimeFormat)
    {
        if (!isset($this->supportedFormats[$desiredDateFormat])) {
            throw $this->createUnknownFormatException($desiredDateFormat);
        }

        if (!isset($this->supportedFormats[$desiredTimeFormat])) {
            throw $this->createUnknownFormatException($desiredTimeFormat);
        }

        $timezone = $this->extractTimezone($dateTime);

        $dateType = $this->supportedFormats[$desiredDateFormat];
        $timeType = $this->supportedFormats[$desiredTimeFormat];

        $formatter = $this->createFormatter($timezone, $dateType, $timeType);

        return $this->realFormat($formatter, $dateTime);
    }

    /**
     * Executes the format method.
     *
     * @param \IntlDateFormatter $formatter Formatter instance used to format the DateTime object.
     * @param \DateTimeInterface $dateTime  Instance of the DateTime object to format.
     *
     * @return string
     */
    private function realFormat(\IntlDateFormatter $formatter, \DateTimeInterface $dateTime)
    {
        return $formatter->format($dateTime);
    }

    /**
     * Creates the formatter.
     *
     * @param string $timezone Timezone to use.
     * @param int    $dateType Type of the formatted date.
     * @param int    $timeType Type of the formatted time.
     *
     * @return \IntlDateFormatter
     */
    private function createFormatter($timezone, $dateType = null, $timeType = null)
    {
        return \IntlDateFormatter::create(
            $this->locale,
            $dateType,
            $timeType,
            $timezone
        );
    }

    /**
     * Creates an UnknownFormatException if an unsupported format was requested.
     *
     * @param string $desiredFormat Unsupported format.
     *
     * @return UnknownFormatException
     */
    private function createUnknownFormatException($desiredFormat)
    {
        return new UnknownFormatException(
            sprintf(
                'The desired format "%s" is invalid. It must be one of the following: %s',
                $desiredFormat,
                implode(", ", array_keys($this->supportedFormats))
            )
        );
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return string
     */
    private function extractTimezone(\DateTimeInterface $dateTime)
    {
        return $dateTime->getTimezone()->getName();
    }
}
