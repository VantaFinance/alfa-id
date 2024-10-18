<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

enum Scope: string
{
    /**
     * Выписки по счетам юр. лиц
     */
    case TRANSACTIONS = 'transactions';

    /**
     * Эскроу счета 214-ФЗ
     */
    case ESCROW = 'escrow';

    /**
     * Профиль организации
     */
    case CUSTOMER = 'customer';

    /**
     * Платёжные поручения
     */
    case PAYMENT = 'payment';

    /**
     * Добавление самозанятых, получение справочных данных
     */
    case AS_OPERATION_WITH_SELF_EMPLOYED = 'as-operation-with-selfemployed';

    /**
     * Статус самозанятого
     */
    case AS_SELF_EMPLOYED_FTS_STATUS = 'as-selfemployed-fts-status';

    /**
     * Налоговые начисления, задолжности и пени самозанятого
     */
    case AS_ACCRUAL_AND_DEBT = 'as-accrual-and-debt';

    /**
     * Проведение выплат и формирование чеков, список банков-участников СБП
     */
    case AS_RECEIPT_AND_PAYOUT = 'as-receipt-and-payout';

    /**
     * Декларация доходов, аннулирование чеков
     */
    case AS_RECEIPT = 'as-receipt';

    /**
     * Проведение выплат самозанятым, список банков-участников СБП
     */
    case AS_PAYOUT_WITH_CHECK_STATUS = 'as-payout-with-check-status';

    /**
     * Осуществление выплат самозанятым
     */
    case AS_PAYOUT = 'as-payout';

    /**
     * Прием оплаты через СБП
     */
    case SBP_TERMINALS_REG = 'sbp_terminals_reg';

    /**
     * Отчеты по операциям СБП
     */
    case REPORT_SBP = 'report-sbp';

    /**
     * Кредиты
     */
    case LOAN_APPLICATIONS = 'loan-applications';

    /**
     * Электронная подпись
     */
    case SIGNATURE = 'signature';

    /**
     * Счета
     */
    case ACCOUNTS = 'accounts';

    /**
     * Карты
     */
    case CARDS = 'cards';

    /**
     * Тарифы и операции по карте
     */
    case CARD_SEC_ACTIONS = 'card-sec-actions';

    /**
     * Истории операций
     */
    case OPERATIONS_HISTORY = 'operations-history';

    /**
     * Переводы с карты на карту
     */
    case C2C_TRANSFERS = 'c2c-transfers';

    /**
     * Получение документов
     */
    case REPORTS_DOWNLOADING = 'reports-downloading';

    /**
     * Выписки по счету
     */
    case DEBIT_STATEMENTS = 'debit-statements';

    /**
     * Справки по кредитам
     */
    case CREDIT_STATEMENTS = 'credit-statements';

    /**
     * Справка по депозиту
     */
    case DEPOSIT_STATEMENTS = 'deposit-statements';

    /**
     * Лимиты по операциям
     */
    case LIMITS_CONTROL = 'limits-control';

    /**
     * Программа лояльности
     */
    case LOYALTY = 'loyalty';

    /**
     * Платежи через СБП
     */
    case B2C_SBP_PAYMENTS = 'b2c_sbp_payments';

    /**
     * Кредитные предложения
     */
    case CREDITS = 'credits';

    /**
     * Оплата покупок через СБП
     */
    case C2B_SBP = 'c2b-sbp';

    /**
     * Операции СБП для юр.лиц
     */
    case B2B_SBP = 'b2b-sbp';

    /**
     * Дебетовая анкета
     */
    case DIGITAL_TARIFF = 'digital-tariff';

    /**
     * Доставка дебетовой карты
     */
    case PLASTIC_DELIVERY = 'plastic-delivery';

    /**
     * Цифровые финансовые активы (ЦФА)
     */
    case DFA = 'dfa';

    /**
     * Зарплатный проект
     */
    case SALARY_PROJECT = 'salary-project';

    /**
     * Управление бенефициарами
     */
    case BENEFICIARIES = 'beneficiaries';
}