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
     * Истинно, если конечный пользователь является ЕИО
     */
    case EIO = 'eio';


    /**
     * Роль конечного пользователя в организации
     */
    case ROLE = 'role';

    /**
     * Адрес регистрации/фактический конечного пользователя
     */
    case ADDRESS_FL = 'addressfl';


    /**
     * Место рождения конечного пользователя
     */
    case BIRTHPLACE = 'birthplace';


    /**
     * ИНН конечного пользователя
     */
    case INN = 'inn';


    /**
     * СНИЛС конечного пользователя
     */
    case SNILS = 'snils';


    /**
     * Документ удостоверяющий личность конечного пользователя
     */
    case IDENTITY_DOCUMENT = 'identitydocument';


    /**
     * Детали документа удостоверяющий личность конечного пользователя
     */
    case IDENTITY_DOCUMENT_DETAILS = 'identitydocumentdetails';
}
