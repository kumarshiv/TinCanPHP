<?php
/*
    Copyright 2014 Rustici Software

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
*/
/*  API Modified for CoursePress and WordPress minimum requirements. */

class TinCanAPI_Context extends TinCanAPI_VersionableInterface {

    protected $registration;
    protected $instructor;
    protected $team;
    protected $contextActivities;
    protected $revision;
    protected $platform;
    protected $language;
    protected $statement;
    protected $extensions;

    public static $directProps = array(
        'registration',
        'revision',
        'platform',
        'language',
    );
    public static $versionedProps = array(
        'instructor',
        'team',
        'contextActivities',
        'statement',
        'extensions',
    );

    public function __construct() {
        if (func_num_args() == 1) {
            $arg = func_get_arg(0);

            $this->_fromArray($arg);
        }

        foreach (
            [
                'contextActivities',
                'extensions',
            ] as $k
        ) {
            $method = 'set' . ucfirst($k);

            if (! isset($this->$k)) {
                $this->$method(array());
            }
        }
    }

    public function setRegistration($value) {
        if (isset($value) && ! preg_match(TinCanAPI_Util::UUID_REGEX, $value)) {
            throw new InvalidArgumentException('arg1 must be a UUID');
        }
        $this->registration = $value;
        return $this;
    }
    public function getRegistration() { return $this->registration; }

    public function setInstructor($value) {
        if (! ($value instanceof TinCanAPI_Agent || $value instanceof TinCanAPI_Group) && is_array($value)) {
            if (isset($value['objectType']) && $value['objectType'] === "TinCanAPI_Group") {
                $value = new TinCanAPI_Group($value);
            }
            else {
                $value = new TinCanAPI_Agent($value);
            }
        }

        $this->instructor = $value;

        return $this;
    }
    public function getInstructor() { return $this->instructor; }

    public function setTeam($value) {
        if (! $value instanceof TinCanAPI_Group && is_array($value)) {
            $value = new TinCanAPI_Group($value);
        }

        $this->team = $value;

        return $this;
    }
    public function getTeam() { return $this->team; }

    public function setContextActivities($value) {
        if (! $value instanceof TinCanAPI_ContextActivities) {
            $value = new TinCanAPI_ContextActivities($value);
        }

        $this->contextActivities = $value;

        return $this;
    }
    public function getContextActivities() { return $this->contextActivities; }

    public function setRevision($value) { $this->revision = $value; return $this; }
    public function getRevision() { return $this->revision; }
    public function setPlatform($value) { $this->platform = $value; return $this; }
    public function getPlatform() { return $this->platform; }
    public function setLanguage($value) { $this->language = $value; return $this; }
    public function getLanguage() { return $this->language; }

    public function setStatement($value) {
        if (! $value instanceof TinCanAPI_StatementRef && is_array($value)) {
            $value = new TinCanAPI_StatementRef($value);
        }

        $this->statement = $value;

        return $this;
    }
    public function getStatement() { return $this->statement; }

    public function setExtensions($value) {
        if (! $value instanceof TinCanAPI_Extensions) {
            $value = new TinCanAPI_Extensions($value);
        }

        $this->extensions = $value;

        return $this;
    }
    public function getExtensions() { return $this->extensions; }
		
}
