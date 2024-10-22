<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

enum Scope: string
{
    case OPENID = 'openid';

    /**
     * Профиль клиента
     */
    case PROFILE = 'profile';


    /**
     * Предпочтительный адрес электронной почты конечного пользователя
     */
    case EMAIL = 'email';


    /**
     * Предпочитаемый номер телефона конечного пользователя
     */
    case PHONE = 'phone';


    /**
     * Пакет услуг конечного пользователя (для юридических лиц не заполняется)
     */
    case PACKAGE_NAME = 'package_name';


    /**
     * ИНН конечного пользователя
     */
    case INN = 'inn';


    /**
     * Документ удостоверяющий личность конечного пользователя
     */
    case IDENTITY_DOCUMENT = 'identitydocument';


    /**
     * Истинно, если конечный пользователь является ЕИО
     */
    case EIO = 'eio';


    /**
     * Роль конечного пользователя в организации
     */
    case ROLE = 'role';

    /**
     * Адрес регистрации/aактический конечного пользователя
     */
    case ADDRESS_FL = 'addressfl';


    /**
     * Место рождения конечного пользователя
     */
    case BIRTHPLACE = 'birthplace';


    /**
     * СНИЛС конечного пользователя
     */
    case SNILS = 'snils';


    /**
     * Детали документа удостоверяющий личность конечного пользователя
     */
    case IDENTITY_DOCUMENT_DETAILS = 'identitydocumentdetails';
}
