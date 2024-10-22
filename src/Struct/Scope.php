<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

enum Scope: string
{
    case OPENID = 'openid';

    case PROFILE = 'profile';

    case EMAIL = 'email';

    case PHONE = 'phone';

    case PACKAGE_NAME = 'package_name';

    case INN = 'inn';

    case IDENTITY_DOCUMENT = 'identitydocument';

    case EIO = 'eio';

    case ROLE = 'role';

    case ADDRESS_FL = 'addressfl';

    case BIRTHPLACE = 'birthplace';

    case SNILS = 'snils';

    case IDENTITY_DOCUMENT_DETAILS = 'identitydocumentdetails';
}
