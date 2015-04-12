<?php
namespace Kyoya\DateTime;

interface FormatterInterface
{
    /**
     * Formats the date and time of a DateTime object using the locale specific default date and time format.
     *
     * @param \DateTimeInterface $dateTime Object to format.
     *
     * @return string
     */
    public function format(\DateTimeInterface $dateTime);

    /**
     * Formats the date of a DateTime object using the specified format.
     *
     * @param \DateTimeInterface $dateTime      Object to format.
     * @param string             $desiredFormat Date format to use.
     *
     * @return string
     */
    public function formatDate(\DateTimeInterface $dateTime, $desiredFormat);

    /**
     * Formats the time of a DateTime object using the specified format.
     *
     * @param \DateTimeInterface $dateTime      Object to format.
     * @param string             $desiredFormat Time format to use.
     *
     * @return string
     */
    public function formatTime(\DateTimeInterface $dateTime, $desiredFormat);

    /**
     * Formats the date and the time of a DateTime object using the specified formats.
     *
     * @param \DateTimeInterface $dateTime          Object to format.
     * @param string             $desiredDateFormat Date format to use.
     * @param string             $desiredTimeFormat Time format to use.
     *
     * @return string
     */
    public function formatDateTime(\DateTimeInterface $dateTime, $desiredDateFormat, $desiredTimeFormat);
}
