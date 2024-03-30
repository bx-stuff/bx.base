<?php


namespace BX\Base\Models;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Error;
use Bitrix\Main\GroupTable;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use BX\Base\Abstractions\AbstractModel;
use CUser;

class UserModel extends AbstractModel
{
    /**
     * @param int $value
     * @return UserModel
     */
    public function setId(int $value): UserModel
    {
        $this["ID"] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setName(string $value): UserModel
    {
        $this["NAME"] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setLastName(string $value): UserModel
    {
        $this["LAST_NAME"] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setSecondName(string $value): UserModel
    {
        $this["SECOND_NAME"] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setEmail(string $value): UserModel
    {
        $this["EMAIL"] = $value;
        return $this;
    }

    /**
     * @return ?DateTime
     */
    public function getTimestampX(): ?DateTime
    {
        return $this["TIMESTAMP_X"] instanceof DateTime ? $this["TIMESTAMP_X"] : null;
    }

    /**
     * @param DateTime $value
     * @return UserModel
     */
    public function setTimestampX(DateTime $value): UserModel
    {
        $this["TIMESTAMP_X"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return (string)$this["LOGIN"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setLogin(string $value): UserModel
    {
        $this["LOGIN"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return (string)$this["ACTIVE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setActive(string $value): UserModel
    {
        $this["ACTIVE"] = $value;
        return $this;
    }

    /**
     * @return ?DateTime
     */
    public function getLastLogin(): ?DateTime
    {
        return $this["LAST_LOGIN"] instanceof DateTime ? $this["LAST_LOGIN"] : null;
    }

    /**
     * @param DateTime $value
     * @return UserModel
     */
    public function setLastLogin(DateTime $value): UserModel
    {
        $this["LAST_LOGIN"] = $value;
        return $this;
    }

    /**
     * @return ?DateTime
     */
    public function getDateRegister(): ?DateTime
    {
        return $this["DATE_REGISTER"] instanceof DateTime ? $this["DATE_REGISTER"] : null;
    }

    /**
     * @param DateTime $value
     * @return UserModel
     */
    public function setDateRegister(DateTime $value): UserModel
    {
        $this["DATE_REGISTER"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLid(): string
    {
        return (string)$this["LID"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setLid(string $value): UserModel
    {
        $this["LID"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalProfession(): string
    {
        return (string)$this["PERSONAL_PROFESSION"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalProfession(string $value): UserModel
    {
        $this["PERSONAL_PROFESSION"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalWww(): string
    {
        return (string)$this["PERSONAL_WWW"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalWww(string $value): UserModel
    {
        $this["PERSONAL_WWW"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalIcq(): string
    {
        return (string)$this["PERSONAL_ICQ"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalIcq(string $value): UserModel
    {
        $this["PERSONAL_ICQ"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalGender(): string
    {
        return (string)$this["PERSONAL_GENDER"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalGender(string $value): UserModel
    {
        $this["PERSONAL_GENDER"] = $value;
        return $this;
    }


    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalBirthday(string $value): UserModel
    {
        $this["PERSONAL_BIRTHDAY"] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getPersonalPhoto(): int
    {
        return (int)$this["PERSONAL_PHOTO"];
    }

    /**
     * @param int $value
     * @return UserModel
     */
    public function setPersonalPhoto(int $value): UserModel
    {
        $this["PERSONAL_PHOTO"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalPhone(): string
    {
        return (string)$this["PERSONAL_PHONE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalPhone(string $value): UserModel
    {
        $this["PERSONAL_PHONE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalFax(): string
    {
        return (string)$this["PERSONAL_FAX"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalFax(string $value): UserModel
    {
        $this["PERSONAL_FAX"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalMobile(): string
    {
        return (string)$this["PERSONAL_MOBILE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalMobile(string $value): UserModel
    {
        $this["PERSONAL_MOBILE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalPager(): string
    {
        return (string)$this["PERSONAL_PAGER"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalPager(string $value): UserModel
    {
        $this["PERSONAL_PAGER"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalStreet(): string
    {
        return (string)$this["PERSONAL_STREET"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalStreet(string $value): UserModel
    {
        $this["PERSONAL_STREET"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalMailbox(): string
    {
        return (string)$this["PERSONAL_MAILBOX"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalMailbox(string $value): UserModel
    {
        $this["PERSONAL_MAILBOX"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalCity(): string
    {
        return (string)$this["PERSONAL_CITY"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalCity(string $value): UserModel
    {
        $this["PERSONAL_CITY"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalState(): string
    {
        return (string)$this["PERSONAL_STATE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalState(string $value): UserModel
    {
        $this["PERSONAL_STATE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalZip(): string
    {
        return (string)$this["PERSONAL_ZIP"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalZip(string $value): UserModel
    {
        $this["PERSONAL_ZIP"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalCountry(): string
    {
        return (string)$this["PERSONAL_COUNTRY"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalCountry(string $value): UserModel
    {
        $this["PERSONAL_COUNTRY"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalNotes(): string
    {
        return (string)$this["PERSONAL_NOTES"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setPersonalNotes(string $value): UserModel
    {
        $this["PERSONAL_NOTES"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkCompany(): string
    {
        return (string)$this["WORK_COMPANY"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkCompany(string $value): UserModel
    {
        $this["WORK_COMPANY"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkDepartment(): string
    {
        return (string)$this["WORK_DEPARTMENT"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkDepartment(string $value): UserModel
    {
        $this["WORK_DEPARTMENT"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkPosition(): string
    {
        return (string)$this["WORK_POSITION"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkPosition(string $value): UserModel
    {
        $this["WORK_POSITION"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkWww(): string
    {
        return (string)$this["WORK_WWW"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkWww(string $value): UserModel
    {
        $this["WORK_WWW"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkPhone(): string
    {
        return (string)$this["WORK_PHONE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkPhone(string $value): UserModel
    {
        $this["WORK_PHONE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkFax(): string
    {
        return (string)$this["WORK_FAX"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkFax(string $value): UserModel
    {
        $this["WORK_FAX"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkPager(): string
    {
        return (string)$this["WORK_PAGER"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkPager(string $value): UserModel
    {
        $this["WORK_PAGER"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkStreet(): string
    {
        return (string)$this["WORK_STREET"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkStreet(string $value): UserModel
    {
        $this["WORK_STREET"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkMailbox(): string
    {
        return (string)$this["WORK_MAILBOX"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkMailbox(string $value): UserModel
    {
        $this["WORK_MAILBOX"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkCity(): string
    {
        return (string)$this["WORK_CITY"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkCity(string $value): UserModel
    {
        $this["WORK_CITY"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkState(): string
    {
        return (string)$this["WORK_STATE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkState(string $value): UserModel
    {
        $this["WORK_STATE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkZip(): string
    {
        return (string)$this["WORK_ZIP"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkZip(string $value): UserModel
    {
        $this["WORK_ZIP"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkCountry(): string
    {
        return (string)$this["WORK_COUNTRY"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkCountry(string $value): UserModel
    {
        $this["WORK_COUNTRY"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkProfile(): string
    {
        return (string)$this["WORK_PROFILE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkProfile(string $value): UserModel
    {
        $this["WORK_PROFILE"] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getWorkLogo(): int
    {
        return (int)$this["WORK_LOGO"];
    }

    /**
     * @param int $value
     * @return UserModel
     */
    public function setWorkLogo(int $value): UserModel
    {
        $this["WORK_LOGO"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkNotes(): string
    {
        return (string)$this["WORK_NOTES"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setWorkNotes(string $value): UserModel
    {
        $this["WORK_NOTES"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminNotes(): string
    {
        return (string)$this["ADMIN_NOTES"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setAdminNotes(string $value): UserModel
    {
        $this["ADMIN_NOTES"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoredHash(): string
    {
        return (string)$this["STORED_HASH"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setStoredHash(string $value): UserModel
    {
        $this["STORED_HASH"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getXmlId(): string
    {
        return (string)$this["XML_ID"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setXmlId(string $value): UserModel
    {
        $this["XML_ID"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalBirthday(): string
    {
        return $this["PERSONAL_BIRTHDAY"];
    }

    /**
     * @return string
     */
    public function getExternalAuthId(): string
    {
        return (string)$this["EXTERNAL_AUTH_ID"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setExternalAuthId(string $value): UserModel
    {
        $this["EXTERNAL_AUTH_ID"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmCode(): string
    {
        return (string)$this["CONFIRM_CODE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setConfirmCode(string $value): UserModel
    {
        $this["CONFIRM_CODE"] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getLoginAttempts(): int
    {
        return (int)$this["LOGIN_ATTEMPTS"];
    }

    /**
     * @param int $value
     * @return UserModel
     */
    public function setLoginAttempts(int $value): UserModel
    {
        $this["LOGIN_ATTEMPTS"] = $value;
        return $this;
    }

    /**
     * @return ?DateTime
     */
    public function getLastActivityDate(): ?DateTime
    {
        return $this["LAST_ACTIVITY_DATE"] instanceof DateTime ? $this["LAST_ACTIVITY_DATE"] : null;
    }

    /**
     * @param DateTime $value
     * @return UserModel
     */
    public function setLastActivityDate(DateTime $value): UserModel
    {
        $this["LAST_ACTIVITY_DATE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAutoTimeZone(): string
    {
        return (string)$this["AUTO_TIME_ZONE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setAutoTimeZone(string $value): UserModel
    {
        $this["AUTO_TIME_ZONE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeZone(): string
    {
        return (string)$this["TIME_ZONE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setTimeZone(string $value): UserModel
    {
        $this["TIME_ZONE"] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeZoneOffset(): int
    {
        return (int)$this["TIME_ZONE_OFFSET"];
    }

    /**
     * @param int $value
     * @return UserModel
     */
    public function setTimeZoneOffset(int $value): UserModel
    {
        $this["TIME_ZONE_OFFSET"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this["TITLE"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setTitle(string $value): UserModel
    {
        $this["TITLE"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBxUserId(): string
    {
        return (string)$this["BX_USER_ID"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setBxUserId(string $value): UserModel
    {
        $this["BX_USER_ID"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguageId(): string
    {
        return (string)$this["LANGUAGE_ID"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setLanguageId(string $value): UserModel
    {
        $this["LANGUAGE_ID"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBlocked(): string
    {
        return (string)$this["BLOCKED"];
    }

    /**
     * @param string $value
     * @return UserModel
     */
    public function setBlocked(string $value): UserModel
    {
        $this["BLOCKED"] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this['NAME'];
    }

    /**
     * @return string
     */
    public function getSecondName(): string
    {
        return (string)$this['SECOND_NAME'];
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return (string)$this['LAST_NAME'];
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        $fio = [
            (string)$this['LAST_NAME'],
            (string)$this['NAME'],
            (string)$this['SECOND_NAME']
        ];
        TrimArr($fio);

        return implode(' ', $fio);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return (string)$this["EMAIL"];
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return (string)$this['PERSONAL_PHONE'];
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return (string)$this['PHONE_NUMBER'];
    }

    /**
     * @param string $value
     * @return \BX\Base\Models\UserModel
     */
    public function setPhoneNumber(string $value): UserModel
    {
        $this["PHONE_NUMBER"] = $value;
        return $this;
    }

    public function getField(string $code)
    {
        return $this[strtoupper($code)];
    }

    public function setField(string $code, $value): UserModel
    {
        $this[strtoupper($code)] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this['ID'];
    }

    public function isAdmin(): bool
    {
        global $USER;

        return $USER->IsAdmin();
    }

    public function getUserGroup(): array
    {
        global $USER;
        $systemGroups = [2, 3, 4];
        $userGroups = $USER->GetUserGroupArray();
        $groups = array_diff($userGroups, $systemGroups);

        try {
            $groupList = GroupTable::getList([
                'filter' => [
                    '=ID' => $groups,
                ],
                'select' => [
                    'ID',
                    'NAME'
                ]
            ])->fetchAll();
            return array_combine(array_column($groupList, 'ID'), array_column($groupList, 'NAME'));
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        return [];
    }

    public function save(): Result
    {
        $result = new Result();
        $cUser = new CUser();

        $id = $this->getId();
        $data = $this->toArray();

        if ($id > 0) {
            unset($data['ID']);
            $isSuccess = (bool)$cUser->Update($id, $data);

            if (!$isSuccess) {
                return $result->addError(new Error("Ошибка обновления пользователя: {$cUser->LAST_ERROR}"));
            }

            return $result;
        }

        $id = (int)$cUser->Add($data);
        if (!$id) {
            return $result->addError(new Error("Ошибка добавления пользователя: {$cUser->LAST_ERROR}"));
        } else {
            $result->setLastId($id);
        }

        return $result;
    }

}