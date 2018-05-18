<?php

namespace Libraries\Utilities;

class ApplicationVersionUtils
{

    /**
     * Gets last git commit hash
     * @param bool $short
     * @return string
     */
    public static function getLastCommitHash(bool $short = true): string
    {
        if ($short) {
            return trim(exec('git log --pretty="%h" -n1 HEAD'));
        }

        return trim(exec('git log --pretty="%H" -n1 HEAD'));
    }

    /**
     * Gets last git commit date
     * @return \DateTime
     */
    public static function getLastCommitDate(): \DateTime
    {
        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

        return $commitDate;
    }

    /**
     * Gets last git tag
     * @param bool $short
     * @return string
     */
    public static function getLastTag(bool $short = true): string
    {
        if ($short) {
            return trim(exec('git describe --tags --abbrev=0'));
        }

        // returs tag with hash
        return trim(exec('git describe --tags'));
    }

    /**
     * Gets application version
     * @return string
     */
    public static function getVersion(): string
    {
        return sprintf('%s.%s (%s)', self::getLastTag(), self::getLastCommitHash(), self::getLastCommitDate()->format('Y-m-d'));
    }

}
