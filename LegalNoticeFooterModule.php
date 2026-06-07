<?php
/*
 * webtrees - Legal Notice
 * custom footer with a link to a page of information containing "Legal Notice / Privacy Policy"
 * (in German: "Impressum / Datenschutzerklärung")
 *
 * based on custom footer module of Josef Prause for Czech locale environment, see
 * https://github.com/jpretired/jp-privacy-policy
 *
 * Partly inspired by mp, see:
 * https://www.webtrees.net/index.php/en/forum/help-for-2-0/35233-how-to-edit-the-privacy-policy-and-the-footer#82090
 *
 * Later adopted the MikeT's way of contact the administrator, see:
 * https://www.webtrees.net/index.php/en/forum/help-for-2-0/35233-how-to-edit-the-privacy-policy-and-the-footer#84085
 *
 * Diskussionen mit Peter Schulz und Burkhard Spiegel (inkl Antworten der Datenschutzbeauftragten, Link zur ct)
 *
 * Diskussionen mit Lars van Ravenzwaaij
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2023 Hermann Hartenthaler. All rights reserved.
 * Copyright (C) 2023 webtrees development team.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; If not, see <https://www.gnu.org/licenses/>.
 */

/*
 * tbd for next release 2.2.1.0
 * ==============================================================
 * falls alle Optionen leer: Optionen aus hh_imprint einlesen und Merker setzen
 * alles neu übersetzen
 *
 * tbd for next release 2.2.1.1
 * ==============================================================
 * alle offenen issues aus GitHub
 * zwei Zwecke definieren: (1) private Forschung zu eigenen Ahnen/Familie (2) OFB zu Ort oder Thema
 * bei "Persönliche Daten zu Ahnen" und "Abgestufte Zugangsrechte": unterschiedliche Formulierung in Abhängigkeit von (1) und (2)
 * bei Hinweis auf Auskunftsrecht auch Hinweis auf Schiedsstellen mit Link wie bei der CompGen-Datenschutzerklärung
 *    "Eine Liste der Aufsichtsbehörden mit Anschrift finden Sie unter: https://www.bfdi.bund.de/DE/Service/Anschriften/Laender/Laender-node.html."
 * Auftragsverarbeitung agreement first/last date/time in zwei Elemente zerlegen (Datum dd.mm.yyyy und Zeit hh:mm) und validieren
 * Nutzeraccount: wird Module oAuth2 verwendet? Darauf hinweisen: wo liegen die Nutzeraccountdaten?
 * "kein tree" Fehler:
 *    Funktion useSingularStyle
 *    Vorbelegung der verantwortlichen Person aus den Angaben für den ersten Website-Administrator (Vor-, Nachname, E-Mail)
 * Zeilenabstände in page.phtml und settings.phtml über CSS statt Leerzeilen realisieren
 * cookie Warnung einbauen, testen und dokumentieren (falls keine externe Cookie-Managementanwendung verwendet wird)
 * READme: Referenzen aus dieser Datei (ganz oben) prüfen und dann übernehmen; ggf. ergänzen um wichtige Artikel
 * Dokumentation in Deutsch im GenWiki für webtrees-Handbuch überarbeiten und dann README anpassen (Rückportierung)
 * neuer Abschnitt: Vereinbarung zu digitalem Nachlass liegt vor
 * neuer Abschnitt: Weitergabe der genealogischen Daten (an GEDBAS, MyHeritage, Ancestry, ...)
 * Angaben wie viele Nutzer welcher Kategorien
 * Angabe wie viele Stammbäume in welcher Größe (sichtbar/unsichtbar für Gäste)
 * Angaben wie die aktuellen webtrees-Einstellungen zum Datenschutz sind
 *
 * tbd later on
 * ==============================================================
 * neue Art der Versionsverwaltung ohne Datei latest-version.txt
 * alle restlichen Konstanten aus diesem Modul als Option in das Verwaltungsmenü in den zugehörigen Abschnitt verschieben
 * Verwaltungsmenü: hierarchische Gestaltung des Menüs für die Datenschutzerklärung (settings)
 * alle Texte zur "Datenschutzerklärung" in die englische Sprache übersetzen
 * Validierung
 *      "copyright start year" auf "4 digits" und Wert "1970..aktuelles Jahr"
 *      Base_URL
 *      postAdminActionChapter
 *      E-Mail-Funktion: check if there is one @ inside emailAddress and no blanks; if address is not correct: use it as simple eMail
 * Code review und Refactoring
 */

/**
 * footer with a link to a "Legal Notice" page
 */

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\LegalNotice;

use Fisharebest\Localization\Translation;
use Fisharebest\Webtrees\Contracts\UserInterface;
use Fisharebest\Webtrees\FlashMessages;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleFooterInterface;
use Fisharebest\Webtrees\Module\ModuleFooterTrait;
use Fisharebest\Webtrees\Module\ModuleConfigInterface;
use Fisharebest\Webtrees\Module\ModuleConfigTrait;
use Fisharebest\Webtrees\Module\PrivacyPolicy;
use Fisharebest\Webtrees\Registry;
use Fisharebest\Webtrees\Services\ModuleService;
use Fisharebest\Webtrees\Services\UserService;
use Fisharebest\Webtrees\Validator;
use Fisharebest\Webtrees\View;
use Hartenthaler\Webtrees\Module\LegalNotice\Internationalization\MoreI18N;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

use function class_exists;
use function count;
use function date;
use function filter_var;
use function is_array;
use function in_array;
use function method_exists;
use function preg_match;
use function preg_replace;
use function trim;
use function file_exists;
use function assert;
use function array_map;
use function view;

class LegalNoticeFooterModule extends PrivacyPolicy
                              implements ModuleCustomInterface, ModuleFooterInterface, ModuleConfigInterface {
    use ModuleCustomTrait;
    use ModuleFooterTrait;
    use ModuleConfigTrait;

    /**
     * list of const for module administration
     */
    public const CUSTOM_TITLE       = 'Legal Notice and Privacy Policy';
    public const CUSTOM_MODULE      = 'hh_legal_notice';
    public const CUSTOM_AUTHOR      = 'Hermann Hartenthaler';
    public const GITHUB_USER        = 'hartenthaler';
    public const CUSTOM_WEBSITE     = 'https://github.com/' . self::GITHUB_USER . '/' . self::CUSTOM_MODULE . '/';
    public const CUSTOM_VERSION     = '2.2.6.1';
    public const CUSTOM_LAST        = 'https://raw.githubusercontent.com/' . self::GITHUB_USER . '/' .
                                            self::CUSTOM_MODULE . '/main/latest-version.txt';
    public const PRIVACY_POLICY_DATE = '2026-06-07';

    private const PRIVACY_POLICY_DATE_SOURCE_RELEASE = 'release';
    private const PRIVACY_POLICY_DATE_SOURCE_MANUAL = 'manual';
    private const PRIVACY_POLICY_DATE_SOURCE_CURRENT = 'current';

    // old module name
    public const OLD_MODULE_NAME_FOR_PREFERENCES = 'hh_imprint';

    // Google Charts is loaded by webtrees statistics pages when these charts are viewed.
    private const GOOGLE_CHARTS_SERVICE = [
        'name' => 'Google Charts',
        'url' => 'https://www.gstatic.com/charts/loader.js',
        'country' => 'United States',
        'privacy_url' => 'https://developers.google.com/chart/interactive/docs/security_privacy',
        'data' => [
            'IP addresses',
            'Browser request metadata',
            'Chart data shown on statistics pages',
        ],
    ];

    private const GRAVATAR_SERVICE = [
        'name' => 'Gravatar',
        'url' => 'https://gravatar.com/',
        'country' => 'United States',
        'privacy_url' => 'https://automattic.com/privacy/',
        'data' => [
            'IP addresses',
            'Browser request metadata',
            'E-mail address hash',
        ],
    ];

    private const OPENSTREETMAP_SERVICE = [
        'name' => 'OpenStreetMap',
        'url' => 'https://www.openstreetmap.org/',
        'country' => 'United Kingdom',
        'privacy_url' => 'https://wiki.openstreetmap.org/wiki/Privacy_Policy',
        'data' => [
            'IP addresses',
            'Location data shown on maps',
            'Map display settings',
        ],
    ];

    private const PRIVACY_LAW_GERMANY = 'germany';
    private const PRIVACY_LAW_EU = 'eu';
    private const PRIVACY_LAW_OTHER = 'other';

    private const EU_COUNTRIES = [
        'austria',
        'belgium',
        'bulgaria',
        'croatia',
        'cyprus',
        'czech republic',
        'czechia',
        'denmark',
        'estonia',
        'finland',
        'france',
        'germany',
        'greece',
        'hungary',
        'ireland',
        'italy',
        'latvia',
        'lithuania',
        'luxembourg',
        'malta',
        'netherlands',
        'poland',
        'portugal',
        'romania',
        'slovakia',
        'slovenia',
        'spain',
        'sweden',
    ];

    /** @var ModuleService */
    private ModuleService $moduleService;

    /** @var UserService */
    private UserService $userService;

    /**
     * constructor
     */
    public function __construct() {
        parent::__construct(
            $this->moduleService = new ModuleService(),
            $this->userService = new UserService()
        );
    }

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return /* I18N: Name of this module */ I18N::translate(self::CUSTOM_TITLE);
    }

    /**
     * A sentence describing what this module does. Used in the list of all installed modules.
     *
     * @return string
     */
    public function description(): string
    {
        return /* I18N: Description of this module */ I18N::translate('Legal notice as a footer element for this site.');
    }

    /**
     * The person or organisation who created this module.
     *
     * {@inheritDoc}
     * @see ModuleCustomInterface::customModuleAuthorName()
     */
    public function customModuleAuthorName(): string
    {
        return self::CUSTOM_AUTHOR;
    }

    /**
     * The version of this module.
     *
     * {@inheritDoc}
     * @see ModuleCustomInterface::customModuleVersion()
     *
     * This module uses a system where the version number is equal to the latest stable version of webtrees.
     * Interim versions get an extra sub number.
     *
     * The dev version is always one step above the latest stable version of this module.
     * The subsequent stable version depends on the version number of the latest stable version of webtrees
     *
     */
    public function customModuleVersion(): string
    {
        return self::CUSTOM_VERSION;
    }

    /**
     * A URL that will provide the latest version of this module.
     *
     * @return string
     */
    public function customModuleLatestVersionUrl(): string
    {
        return self::CUSTOM_LAST;
    }

    /**
     * Where to get support for this module?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return self::CUSTOM_WEBSITE;
    }

    /**
     * Where does this module store its resources?
     *
     * @return string
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR;
    }

    /**
     * {@inheritDoc}
     *
     * @param string $language
     *
     * @return array
     *
     * @see \Fisharebest\Webtrees\Module\ModuleCustomInterface::customTranslations()
     */
    public function customTranslations(string $language): array
    {
        $lang_dir = $this->resourcesFolder() . 'lang' . DIRECTORY_SEPARATOR;
        $file = $lang_dir . $language . '.mo';

        if (file_exists($file)) {
            return (new Translation($file))->asArray();
        } else {
            return [];
        }
    }

    /**
     * Bootstrap the module
     *
     * Here is also a good place to register any views (templates) used by the module.
     * This command allows the module to use: view($this->name() . '::', 'fish')
     * to access the file ./resources/views/fish.phtml
     */
    public function boot(): void
    {
        // Register a namespace for our views.
        View::registerNamespace($this->name(), strtr($this->resourcesFolder() . 'views' . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, '/'));
    }

    /**
     * generate list of preferences (control panel options)
     * there are more options like order of chapters or options to show or not to show a chapter
     *
     * @return array<int,string>
     */
    private function listOfPreferences(): array
    {
        return [
            'showCopyRight',
            'copyRightStartYear',
            'copyRightName',
            'responsibleFirst',
            'responsibleSurname',
            'responsibleSex',
            'showGravatar',
            'organization',
            'additionalAddress',
            'street',
            'city',
            'phone',
            'fax',
            'email',
            'simpleEmail',
            'vatNumberLabel',
            'vatNumber',
            'showTreeContacts',
            'showAdministrators',
            'showDisputeResolution',
            'registeredUsersAreRelatives',
            'supervisoryAuthorityName',
            'supervisoryAuthorityUrl',
            'hostingCountry',
            'hostingCompanyName',
            'hostingCompanyUrl',
            'hostingPrivacyNotice',
            'orderProcessing',
            'hostingStartDate',
            'hostingEndDate',
            'privacyPolicyDateSource',
            'privacyPolicyManualDate',
            'showGoogleCharts',
            'additionalThirdPartyServices',
        ];
    }

    /**
     * Open control panel page with options
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function getAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->layout = 'layouts/administration';
        return $this->viewResponse($this->name() . '::' . 'settings', $this->getInitializedOptions($request));
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    private function getInitializedOptions(ServerRequestInterface $request): array
    {
        $response = [];

        $response['title'] = $this->moduleTitle();
        $response['description'] = $this->description();
        $response['chapters'] = $this->getChapters($request);
        $response['dataProtectionSectionKeys'] = LegalNoticeSupport::listDataProtectionSectionKeys();
        $response['registeredUserNames'] = $this->registeredUserNames();

        $preferences = $this->listOfPreferences();
        foreach ($preferences as $preference) {
            $response[$preference] = $this->getPreference($preference);
        }
        $this->checkOptions($request, $response);

        return $response;
    }

    /**
     * check options and set default e.g. if the module is called the first time
     *
     * @param ServerRequestInterface $request
     * @param array $response
     */
    private function checkOptions(ServerRequestInterface $request, array & $response): void
    {
        // check if this module is called the first time; then transfer the preferences from the former module hh_imprint
        $this->checkModuleVersionUpdate();

        // modify some elements with default values if they are not set
        if (false && $response['responsibleFirst'] == '' && $response['responsibleSurname'] == '') {    // tbd Fehlermeldung: "tree" fehlt
            $contactsListObject = new ContactsList($this->userService, $request);
            // there is always at least one administrator; use this first one to initialize the responsible person
            $defaultAdministrator = $contactsListObject->getAdministratorsList()[0];
            $response['responsibleFirst'] = $defaultAdministrator->realName;     // tbd split in first name and surname
            $response['responsibleSurname'] = $defaultAdministrator->realName;   // tbd split in first name and surname

            if ($response['email'] == '') {
                $response['email'] = $defaultAdministrator->email;
            }
        }

        if ($response['responsibleSex'] == '') {
            $response['responsibleSex'] = 'U';
        }

        if ($response['showGoogleCharts'] === '') {
            $response['showGoogleCharts'] = '1';
        }

        if ($response['privacyPolicyDateSource'] === '') {
            $response['privacyPolicyDateSource'] = self::PRIVACY_POLICY_DATE_SOURCE_RELEASE;
        }
    }

    /**
     * Check if module is started the first time and then start update activities
     *
     * @return void
     */
    public function checkModuleVersionUpdate(): void
    {
        // if started for the very first time, try to migrate preferences of former module
        if ($this->getPreference('versionImprintLegalNotice', '') === '') {
            $this->migratePreferencesFromFormerModule();
            $this->setPreference('versionImprintLegalNotice', self::CUSTOM_VERSION);
        }
    }

    /**
     * Migration from former module hh_imprint to current module hh_legal_notice
     * Transfer the user preferences for all settings if the new module is called the first time
     *
     * @return void
     */
    public function migratePreferencesFromFormerModule(): void {

        $updated_settings = false;

        // set new values for preferences based on old values
        $preferences = $this->listOfPreferences();
        foreach($preferences as $preference) {
            $setting_value = $this->getPreferenceForModule(self::OLD_MODULE_NAME_FOR_PREFERENCES, $preference, '');

            if ($setting_value !== '') {
                $this->setPreference($preference, $setting_value);
                $updated_settings = true;
            }
        }

        // set new value for order of chapters based on old values
        $setting_value = $this->getPreferenceForModule(self::OLD_MODULE_NAME_FOR_PREFERENCES, 'order', '');
        if ($setting_value !== '') {
            $this->setPreference('order', $setting_value);
            $updated_settings = true;
        }

        $chapterKeys = LegalNoticeSupport::listChapterKeys();
        foreach ($chapterKeys as $chapterKey) {
            $this->setPreference('status-' . $chapterKey, '0');
            $setting_value = $this->getPreferenceForModule(self::OLD_MODULE_NAME_FOR_PREFERENCES, 'status-' . $chapterKey, '');
            if ($setting_value !== '') {
                $this->setPreference('status-' . $chapterKey, $setting_value);
                $updated_settings = true;
            }
        }

        // inform user
        if ($updated_settings) {
            //Show flash message for update of preferences
            $message = I18N::translate('The preferences for the custom module "%s" were imported from the earlier custom module "%s".',
                                    $this->title(), self::OLD_MODULE_NAME_FOR_PREFERENCES);
            FlashMessages::addMessage($message, 'success');
        }
    }

    /**
     * Get a module setting for a module. Return a default if the setting is not set.
     *
     * @param string $module_name (without '_' at the beginning and end of the name)
     * @param string $setting_name name of setting
     * @param string $default default value
     *
     * @return string
     */
    final public function getPreferenceForModule(string $module_name, string $setting_name, string $default = ''): string
    {
        //Code from: webtrees AbstractModule->getPreference
        return DB::table('module_setting')
            ->where('module_name', '=', '_' . $module_name . '_')
            ->where('setting_name', '=', $setting_name)
            ->value('setting_value') ?? $default;
    }

    /**
     * Save the user preferences in the database
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function postAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        if (Validator::parsedBody($request)->string('save') === '1') {
            $this->postAdminActionSave($request);
            FlashMessages::addMessage(MoreI18N::xlate('The preferences for the module “%s” have been updated.',
                $this->title()), 'success');
        }
        return redirect($this->getConfigLink());
    }

    /**
     * Save the user preferences for all parameters
     *
     * @param ServerRequestInterface $request
     */
    private function postAdminActionSave(ServerRequestInterface $request)
    {
        $body = Validator::parsedBody($request);
        $preferences = $this->listOfPreferences();

        foreach ($preferences as $preference) {
            $this->setPreference($preference, $this->validatedPreference($preference, $body->string($preference, '')));
        }

        $this->postAdminActionChapter($request);
    }

    private function validatedPreference(string $preference, string $value): string
    {
        $value = trim($value);

        return match ($preference) {
            'showCopyRight',
            'showGravatar',
            'simpleEmail',
            'showTreeContacts',
            'showAdministrators',
            'showDisputeResolution',
            'orderProcessing',
            'registeredUsersAreRelatives',
            'showGoogleCharts' => $value === '1' ? '1' : '0',

            'responsibleSex' => in_array($value, ['M', 'F', 'X', 'U'], true) ? $value : 'U',

            'copyRightStartYear' => $this->validatedYear($value),

            'privacyPolicyDateSource' => in_array($value, [
                self::PRIVACY_POLICY_DATE_SOURCE_RELEASE,
                self::PRIVACY_POLICY_DATE_SOURCE_MANUAL,
                self::PRIVACY_POLICY_DATE_SOURCE_CURRENT,
            ], true) ? $value : self::PRIVACY_POLICY_DATE_SOURCE_RELEASE,

            'privacyPolicyManualDate' => $this->validatedIsoDate($value, $preference),

            'email' => $this->validatedEmail($value),

            'hostingCompanyUrl',
            'hostingPrivacyNotice' => $this->validatedUrl($value, $preference),
            'supervisoryAuthorityUrl' => $this->validatedUrl($value, $preference),

            'additionalThirdPartyServices' => $this->validatedThirdPartyServices($value),

            default => $value,
        };
    }

    private function validatedYear(string $value): string
    {
        if ($value === '') {
            return '';
        }

        $year = (int) $value;
        $current_year = (int) date('Y');

        if (preg_match('/^\d{4}$/', $value) === 1 && $year >= 1970 && $year <= $current_year) {
            return $value;
        }

        FlashMessages::addMessage(I18N::translate('Invalid copyright start year. The value was ignored.'), 'warning');

        return '';
    }

    private function validatedIsoDate(string $value, string $preference): string
    {
        if ($value === '') {
            return '';
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) === 1) {
            [$year, $month, $day] = array_map('intval', explode('-', $value));

            if (checkdate($month, $day, $year)) {
                return $value;
            }
        }

        FlashMessages::addMessage(I18N::translate('Invalid date in setting “%s”. Use the format YYYY-MM-DD. The value was ignored.', $preference), 'warning');

        return '';
    }

    private function validatedEmail(string $value): string
    {
        if ($value === '' || filter_var($value, FILTER_VALIDATE_EMAIL) !== false) {
            return $value;
        }

        FlashMessages::addMessage(I18N::translate('Invalid e-mail address. The value was ignored.'), 'warning');

        return '';
    }

    private function validatedUrl(string $value, string $preference): string
    {
        if ($value === '' || $this->isValidHttpUrl($value)) {
            return $value;
        }

        FlashMessages::addMessage(I18N::translate('Invalid URL in setting “%s”. The value was ignored.', $preference), 'warning');

        return '';
    }

    private function validatedThirdPartyServices(string $value): string
    {
        $valid_lines = [];
        $invalid_lines = 0;
        $lines = preg_split('/\R/', $value) ?: [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parts = preg_split('/\s*\|\s*/', $line, 3);

            if ($parts === false || count($parts) < 2) {
                $invalid_lines++;
                continue;
            }

            $name = trim($parts[0]);
            $url = trim($parts[1]);
            $country = trim($parts[2] ?? '');

            if ($name === '' || !$this->isValidHttpUrl($url)) {
                $invalid_lines++;
                continue;
            }

            $valid_lines[] = $country === ''
                ? $name . ' | ' . $url
                : $name . ' | ' . $url . ' | ' . $country;
        }

        if ($invalid_lines > 0) {
            FlashMessages::addMessage(I18N::plural('One invalid third-party service entry was ignored.', '%s invalid third-party service entries were ignored.', $invalid_lines, I18N::number($invalid_lines)), 'warning');
        }

        return implode("\n", $valid_lines);
    }

    private function isValidHttpUrl(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return preg_match('/^https?:\/\//i', $url) === 1;
    }

    /**
     * save the user preferences for all parameters related to the chapters of this module in the database
     * order of chapters and status of chapters (enabled/disabled)
     *
     * @param ServerRequestInterface $request
     */
    private function postAdminActionChapter(ServerRequestInterface $request)
    {
        $params = (array) $request->getParsedBody();
        $order = Validator::parsedBody($request)->string('resetOrder', '') === '1'
            ? $this->defaultChapterOrder()
            : $this->validatedChapterOrder($params['order'] ?? []);

        $this->setPreference('order', implode(',', $order));
        foreach (LegalNoticeSupport::listChapterKeys() as $chapterKey) {
            $this->setPreference('status-' . $chapterKey, '0');
        }
        foreach ($params as $key => $value) {
            if (str_starts_with($key, 'status-') && in_array(substr($key, 7), LegalNoticeSupport::listChapterKeys(), true)) {
                $this->setPreference($key, $value);
            }
        }
    }

    /**
     * @return array<int,string>
     */
    private function defaultChapterOrder(): array
    {
        return LegalNoticeSupport::listChapterKeys();
    }

    /**
     * @param mixed $submittedOrder
     *
     * @return array<int,string>
     */
    private function validatedChapterOrder(mixed $submittedOrder): array
    {
        $defaultOrder = $this->defaultChapterOrder();

        if (!is_array($submittedOrder)) {
            return $defaultOrder;
        }

        $submittedOrder = array_filter($submittedOrder, static fn (mixed $chapterKey): bool => is_string($chapterKey));
        $order = array_values(array_intersect($submittedOrder, $defaultOrder));

        return array_values(array_unique([...$order, ...$defaultOrder]));
    }

    /**
     * A footer, to be added at the bottom of every page.
     *
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    public function getFooter(ServerRequestInterface $request): string
    {
        $tree = Validator::attributes($request)->treeOptional();
        if ($tree === null) {
            return '';
        }

        $user = $request->getAttribute('user');
        assert($user instanceof UserInterface);

        $title = I18N::translate('Legal Notice');
        if ($this->isChapterEnabled('DataProtection', $request)) {
            $title .= ' ' . I18N::translate('and Privacy Policy');
        }

        $url = route('module', [
            'module' => $this->name(),
            'action' => 'Page',
            'tree'   => $tree?->name(),
        ]);

        return view($this->name() . '::footer', [
            'title'              => $title,
            'url'                => $url,
            'showCopyRight'      => $this->showCopyRight(),
            'copyRightStartYear' => $this->copyRightStartYear(),
            'copyRightName'      => $this->copyRightName(),
            'cookiesWarning'     => LegalNoticeSupport::useBuildInCookiesWarning(
                $tree, $user, [], []),
            'cookiesMessage'     => I18N::translate('This website uses cookies.'),
        ]);
    }

    /**
     * Generate the page that will be shown when a user clicks the link in the footer.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function getPageAction(ServerRequestInterface $request): ResponseInterface
    {
        $contactsListObject = new ContactsList($this->userService, $request);
        $responsibleName = $this->responsibleName();
        $responsibleContactNotices = [];
        $contactsTreeContacts = [];
        $contactsAdministrators = [];

        if ($this->showTreeContacts()) {
            foreach ($contactsListObject->getTreeContactsList() as $contact) {
                if ($this->isResponsibleContactName($contact->realName, $responsibleName)) {
                    $responsibleContactNotices[] = $this->treeContactNotice($contact->role, $contact->contactLink);
                    continue;
                }

                $contactsTreeContacts[] = $contact->contact;
            }
        }

        if ($this->showAdministrators()) {
            foreach ($contactsListObject->getAdministratorsList() as $admin) {
                if ($this->isResponsibleContactName($admin->realName, $responsibleName)) {
                    $responsibleContactNotices[] = $this->administratorContactNotice($admin->contact);
                    continue;
                }

                $contactsAdministrators[] = $admin->contact;
            }
        }

        $tree = Validator::attributes($request)->treeOptional();
        $user = $request->getAttribute('user');         // tbd: replace by Validator::attributes($request)->user()
        assert($user instanceof UserInterface);
        $privacyLawRegion = $this->privacyLawRegion();

        return $this->viewResponse($this->name() . '::page', [
            'moduleName'                => $this->name(),
            'title'                     => $this->title(),
            'tree'                      => $tree,
            'legalNoticeTitle'          => I18N::translate('Legal Notice'),
            'legalNoticeHead1'          => I18N::translate('Responsible person'),
            'legalNoticeHead2'          => I18N::translate('This website is operated by:'),
            'privacyPolicyDate'         => $this->formattedPrivacyPolicyDate(),
            'responsibleName'           => $responsibleName,
            'responsibleContactNotices' => array_values(array_unique($responsibleContactNotices)),
            'showGravatar'              => $this->showGravatar(),
            'image'                     => LegalNoticeSupport::getGravatar($this->getPreference('email', ''),'40'),
            'organization'              => $this->organization(),
            'representedBy'             => I18N::translate('Represented by:'),
            'additionalAddress'         => $this->additionalAddress(),
            'street'                    => $this->street(),
            'city'                      => $this->city(),
            'phoneLabel'                => MoreI18N::xlate('Phone'),
            'phone'                     => $this->phone(),
            'faxLabel'                  => MoreI18N::xlate('Fax'),
            'fax'                       => $this->fax(),
            'emailLabel'                => MoreI18N::xlate('eMail'),
            'email'                     => $this->email($request),
            'vatNumberLabel'            => $this->vatNumberLabel(),
            'vatNumber'                 => $this->vatNumber(),
            'showTreeContacts'          => $this->showTreeContacts(),
            'headTreeContacts'          => I18N::plural('Additional contact','Additional contacts', count($contactsTreeContacts)),
            'countTreeContacts'         => count($contactsTreeContacts),
            'contactsTreeContacts'      => $contactsTreeContacts,
            'showAdministrators'        => $this->showAdministrators(),
            'headAdministrators'        => I18N::plural('Website administrator','Website administrators', count($contactsAdministrators)),
            'commentAdministrators'     => I18N::plural('The webtrees administrator is responsible to manage users and to set the preferences for this website.',
                                            'The webtrees administrators are responsible to manage users and to set the preferences for this website.', count($contactsAdministrators)),
            'countAdministrators'       => count($contactsAdministrators),
            'contactsAdministrators'    => $contactsAdministrators,
            'registeredUsersAreRelatives' => $this->registeredUsersAreRelatives(),
            'supervisoryAuthorityName' => $this->supervisoryAuthorityName(),
            'supervisoryAuthorityUrl' => $this->supervisoryAuthorityUrl(),
            'chapters'                  => $this->getChapters($request),
            'dataProtectionSectionKeys' => LegalNoticeSupport::listDataProtectionSectionKeys(),
            'sectionViewByChapterKey'   => LegalNoticeSupport::sectionViewByChapterKey(),
            'showDataProtection'        => $this->isChapterEnabled('DataProtection', $request),
            'showLegalRegulations'      => $this->isChapterEnabled('LegalRegulations', $request),
            'singular'                  => $this->useSingularStyle($request),
            'analytics'                 => $this->analyticsModules($tree, $user),
            'trackingServices'          => [],
            'thirdPartyServices'        => $this->thirdPartyServices(),
            'cookiesServices'           => [],
            'externalTranscriptionProviders' => [],
            //'usercentricsLanguages' => self::USERCENTRICS_LANGUAGES,
            'https'                     => legalNoticeSupport::getHttps($request),
            'hostingDomain'             => LegalNoticeSupport::getHostName($request),
            'hostingCountry'            => I18N::translate($this->hostingCountry()),
            'privacyLawRegion'          => $privacyLawRegion,
            'useGermanPrivacyLaw'        => $privacyLawRegion === self::PRIVACY_LAW_GERMANY,
            'useEuPrivacyLaw'            => $privacyLawRegion !== self::PRIVACY_LAW_OTHER,
            'hostingCompanyName'        => $this->hostingCompanyName(),
            'hostingCompanyUrl'         => $this->hostingCompanyUrl(),
            'hostingPrivacyNotice'      => $this->hostingPrivacyNotice(),
            'orderProcessing'           => $this->isOrderProcessingUsed(),
            'hostingStartDate'          => $this->hostingStartDate(),
            'hostingEndDate'            => $this->hostingEndDate(),
        ]);
    }

    /**
     * @return list<array{name:string,url:string,country:string,thirdCountryTransfer:bool}>
     */
    private function thirdPartyServices(): array
    {
        $services = $this->showGoogleCharts() ? [self::GOOGLE_CHARTS_SERVICE] : [];

        if ($this->showGravatar()) {
            $services[] = self::GRAVATAR_SERVICE;
        }

        if ($this->isModuleEnabled('openstreetmap')) {
            $services[] = self::OPENSTREETMAP_SERVICE;
        }

        $services = [
            ...$services,
            ...$this->externalTranscriptionProviders(),
        ];

        return array_map(fn (array $service): array => $this->withThirdCountryTransferFlag($service), [
            ...$services,
            ...$this->additionalThirdPartyServices(),
        ]);
    }

    private function showGoogleCharts(): bool
    {
        return $this->getPreference('showGoogleCharts', '1') !== '0' && $this->isModuleEnabled('statistics_chart');
    }

    private function isModuleEnabled(string $moduleName): bool
    {
        return $this->moduleService->findByName($moduleName) !== null;
    }

    /**
     * @return list<array{name:string,url:string,country:string}>
     */
    private function additionalThirdPartyServices(): array
    {
        $services = [];
        $lines = preg_split('/\R/', $this->getPreference('additionalThirdPartyServices', '')) ?: [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parts = preg_split('/\s*\|\s*/', $line, 3);

            if ($parts === false || count($parts) < 2) {
                continue;
            }

            $name = trim($parts[0]);
            $url = trim($parts[1]);
            $country = trim($parts[2] ?? '');

            if ($name !== '' && $url !== '') {
                $services[] = [
                    'name' => $name,
                    'url' => $url,
                    'country' => $country,
                ];
            }
        }

        return $services;
    }

    /**
     * External transcription providers announced by hh_source_transcription, if installed.
     *
     * @return list<array{name:string,url:string,country:string,data:list<string>,thirdCountryTransfer:bool}>
     */
    private function externalTranscriptionProviders(): array
    {
        $sourceTranscription = '\Hartenthaler\Webtrees\Module\SourceTranscription\SourceTranscription';

        if (!class_exists($sourceTranscription) || !method_exists($sourceTranscription, 'externalProviderPrivacyNotices')) {
            return [];
        }

        try {
            $providers = $sourceTranscription::externalProviderPrivacyNotices();
        } catch (Throwable) {
            return [];
        }

        if (!is_array($providers)) {
            return [];
        }

        return array_map(fn (array $provider): array => $this->withThirdCountryTransferFlag($provider), $providers);
    }

    private function registeredUsersAreRelatives(): bool
    {
        return $this->getPreference('registeredUsersAreRelatives', '0') === '1';
    }

    private function registeredUserNames(): string
    {
        return implode(', ', $this->userService->all()
            ->map(static fn (UserInterface $user): string => $user->realName() !== '' ? $user->realName() : $user->userName())
            ->all());
    }

    private function isResponsibleContactName(string $contactName, string $responsibleName): bool
    {
        return $this->normalizedContactName($contactName) !== ''
            && $this->normalizedContactName($contactName) === $this->normalizedContactName($responsibleName);
    }

    private function normalizedContactName(string $name): string
    {
        return strtolower(trim((string) preg_replace('/\s+/', ' ', $name)));
    }

    private function treeContactNotice(string $role, string $contactLink): string
    {
        return match ($role) {
            'genealogy' => I18N::translate('%1$s is %2$s for genealogy questions.', $this->responsiblePronoun(), $this->contactActionLink($contactLink)),
            'technical' => I18N::translate('%1$s is %2$s for technical support.', $this->responsiblePronoun(), $this->contactActionLink($contactLink)),
            default => I18N::translate('%1$s is %2$s for technical support or genealogy questions.', $this->responsiblePronoun(), $this->contactActionLink($contactLink)),
        };
    }

    private function administratorContactNotice(string $contactLink): string
    {
        return I18N::translate('%1$s is %2$s as website administrator and is responsible for managing users and setting the options for this website.', $this->responsiblePronoun(), $this->contactActionLink($contactLink));
    }

    private function contactActionLink(string $contactLink): string
    {
        if (preg_match('/href="([^"]+)"/', $contactLink, $match) !== 1) {
            return I18N::translate('available');
        }

        return '<a href="' . e($match[1]) . '" rel="nofollow">' . I18N::translate('available') . '</a>';
    }

    private function responsiblePronoun(): string
    {
        return match ($this->responsibleSex()) {
            'M' => I18N::translate('He'),
            'F' => I18N::translate('She'),
            default => I18N::translate('This person'),
        };
    }

    private function withThirdCountryTransferFlag(array $service): array
    {
        $service['country'] = (string) ($service['country'] ?? '');
        $service['thirdCountryTransfer'] = $this->isThirdCountryTransfer($service['country']);

        return $service;
    }

    private function isThirdCountryTransfer(string $country): bool
    {
        if ($this->privacyLawRegion() === self::PRIVACY_LAW_OTHER || trim($country) === '') {
            return false;
        }

        return !$this->isEuPrivacyCountry($country);
    }

    /**
     * title of this module used in the headings
     *
     * @return string
     */
    private function moduleTitle(): string
    {
        return I18N::translate('Legal Notice and Privacy Policy');;
    }

    /**
     * should a copy right notice be shown?
     *
     * @return bool
     */
    private function showCopyRight(): bool
    {
        return ($this->getPreference('showCopyRight', '0') !== '0');
    }

    /**
     * show copy right start year               // tbd check "4 digits" and value "1970..aktuelles Jahr"
     *
     * @return string
     */
    private function copyRightStartYear(): string
    {
        return $this->getPreference('copyRightStartYear', '');
    }

    /**
     * name of holder of copy right
     *
     * @return string
     */
    private function copyRightName(): string
    {
        return $this->getPreference('copyRightName', '');
    }

    /**
     * first name(s) of responsible person
     *
     * @return string
     */
    private function responsibleFirst(): string
    {
        return $this->getPreference('responsibleFirst', '');
    }

    /**
     * surname(s) of responsible person
     *
     * @return string
     */
    private function responsibleSurname(): string
    {
        return $this->getPreference('responsibleSurname', '');
    }

    /**
     * name of responsible person, assuming that the sequence is first name and then last name
     *
     * @return string
     */
    private function responsibleName(): string
    {
        return trim($this->responsibleFirst() . ' ' . $this->responsibleSurname());
    }

    /**
     * sex of responsible person
     *
     * @return string
     */
    private function responsibleSex(): string
    {
        return $this->getPreference('responsibleSex', 'M');
    }

    /**
     * should a gravatar image be shown?
     *
     * @return bool
     */
    private function showGravatar(): bool
    {
        return ($this->getPreference('showGravatar', '0') !== '0');
    }

    /**
     * organization
     *
     * @return string
     */
    private function organization(): string
    {
        return $this->getPreference('organization', '');
    }

    /**
     * additional address line
     *
     * @return string
     */
    private function additionalAddress(): string
    {
        return $this->getPreference('additionalAddress', '');
    }

    /**
     * street name and house number of responsible person
     *
     * @return string
     */
    private function street(): string
    {
        return $this->getPreference('street', '');
    }

    /**
     * city and zip code of responsible person
     *
     * @return string
     */
    private function city(): string
    {
        return $this->getPreference('city', '');
    }

    /**
     * phone number of responsible person
     *
     * @return string
     */
    private function phone(): string
    {
        return $this->getPreference('phone', '');
    }

    /**
     * fax number of responsible person
     *
     * @return string
     */
    private function fax(): string
    {
        return $this->getPreference('fax', '');
    }

    /**
     * E-Mail address of responsible person in two versions
     * - only eMail address
     * - eMail address and additionally parameter for subject and first line of body
     *
     * @param ServerRequestInterface $request
     * @param bool $simpleEmail Optional, use true to force a simple Email address without subject and body
     *
     * @return string
     */
    private function email(ServerRequestInterface $request, bool $simpleEmail = false): string
    {
        $emailAddress = $this->getPreference('email', '');

        if ($emailAddress !== '') {
            if ($simpleEmail || $this->simpleEmail()) {
                $emailLink = '<a href="mailto:' .
                    e($emailAddress) .
                    '" style="background-color:transparent;color:rgb(85,85,85);text-decoration:none;">' .
                    e($emailAddress) .
                    '</a>';
            } else {
                $subject = /* I18N: subject of e-mail */
                    I18N::translate('message via legal notice of site %s', LegalNoticeSupport::getHostName($request));
                if ($this->responsibleSex() == 'M') {
                    $body = /* I18N: first line of body of e-mail using surname */
                        I18N::translate('Dear Mr. %s', $this->responsibleSurname()) . ',';
                } elseif ($this->responsibleSex() == 'F') {
                    $body = /* I18N: first line of body of e-mail using surname */
                        I18N::translate('Dear Mrs. %s', $this->responsibleSurname()) . ',';
                } else {
                    $body = /* I18N: first line of body of e-mail using full name */
                        I18N::translate('Dear %s', $this->responsibleName()) . ',';
                }

                $emailLink = '<a href="mailto:' .
                    e($emailAddress) .
                    '?subject=' .
                    e($subject) .
                    '&amp;body=' .
                    e($body) .
                    '" style="background-color:transparent;color:rgb(85,85,85);text-decoration:none;">' .
                    e($emailAddress) .
                    '</a>';
            }
            return $emailLink;
        } else {
            return '';
        }
    }

    /**
     * should a simple or a more complex E-Mail address of the responsible person be used?
     *
     * @return bool
     */
    private function simpleEmail(): bool
    {
        return ($this->getPreference('simpleEmail', '0') !== '0');
    }

    /**
     * Label for VAT number or other registration number
     *
     * @return string
     */
    private function vatNumberLabel(): string
    {
        return $this->getPreference('vatNumberLabel', '');
    }

    /**
     * VAT number or other registration number
     *
     * @return string
     */
    private function vatNumber(): string
    {
        return $this->getPreference('vatNumber', '');
    }

    /**
     * should the tree contacts be shown
     *
     * @return bool
     */
    private function showTreeContacts(): bool
    {
        return ($this->getPreference('showTreeContacts', '0') !== '0');
    }

    /**
     * should the tree contacts be shown
     *
     * @return bool
     */
    private function showAdministrators(): bool
    {
        return ($this->getPreference('showAdministrators', '0') !== '0');
    }

    /**
     * should a consumer dispute resolution notice be shown for EU server locations?
     *
     * @return bool
     */
    private function showDisputeResolution(): bool
    {
        return $this->getPreference('showDisputeResolution', '0') === '1';
    }

    private function supervisoryAuthorityName(): string
    {
        return $this->getPreference('supervisoryAuthorityName', '');
    }

    private function supervisoryAuthorityUrl(): string
    {
        return $this->getPreference('supervisoryAuthorityUrl', '');
    }

    /**
     * country of the webtrees server location (in English language)
     * e.g. Germany
     *
     * @return string
     */
    private function hostingCountry(): string
    {
        return $this->getPreference('hostingCountry', '');
    }

    private function privacyPolicyDate(): string
    {
        return match ($this->getPreference('privacyPolicyDateSource', self::PRIVACY_POLICY_DATE_SOURCE_RELEASE)) {
            self::PRIVACY_POLICY_DATE_SOURCE_MANUAL => $this->privacyPolicyManualDate() !== ''
                ? $this->privacyPolicyManualDate()
                : self::PRIVACY_POLICY_DATE,
            self::PRIVACY_POLICY_DATE_SOURCE_CURRENT => date('Y-m-d'),
            default => self::PRIVACY_POLICY_DATE,
        };
    }

    private function formattedPrivacyPolicyDate(): string
    {
        $date = $this->privacyPolicyDate();

        if ($date === '') {
            return '';
        }

        return Registry::timestampFactory()->fromString($date, 'Y-m-d')->isoFormat('L');
    }

    private function privacyPolicyManualDate(): string
    {
        return $this->getPreference('privacyPolicyManualDate', '');
    }

    private function privacyLawRegion(): string
    {
        $country = strtolower(trim($this->hostingCountry()));

        if ($country === '') {
            return self::PRIVACY_LAW_OTHER;
        }

        if ($this->isGermany($country)) {
            return self::PRIVACY_LAW_GERMANY;
        }

        return $this->isEuPrivacyCountry($country)
            ? self::PRIVACY_LAW_EU
            : self::PRIVACY_LAW_OTHER;
    }

    private function isEuPrivacyCountry(string $country): bool
    {
        $country = strtolower(trim($country));

        return $this->isGermany($country) || in_array($country, self::EU_COUNTRIES, true);
    }

    private function isGermany(string $country): bool
    {
        return in_array(strtolower(trim($country)), ['germany', 'deutschland'], true);
    }

    /**
     * hosting service company name
     * e.g. Strato
     *
     * @return string
     */
    private function hostingCompanyName(): string
    {
        return $this->getPreference('hostingCompanyName', '');
    }

    /**
     * hosting service link (URL)
     * e.g. https://strato.de
     *
     * @return string
     */
    private function hostingCompanyUrl(): string
    {
        return $this->getPreference('hostingCompanyUrl', '');
    }

    /**
     * hosting service link to privacy notice (URL)
     * e.g. https://www.strato.de/datenschutz
     *
     * @return string
     */
    private function hostingPrivacyNotice(): string
    {
        return $this->getPreference('hostingPrivacyNotice', '');
    }

    /**
     * is a Order Processing (Auftragsverarbeitung) agreement used?
     *
     * @return bool
     */
    private function isOrderProcessingUsed(): bool
    {
        return ($this->getPreference('orderProcessing') !== '0');
    }

    /**
     * hosting Auftragsverarbeitung agreement first date / time             // tbd should be 2 elements date + time
     * e.g. 26.11.2018 um 00:12 Uhr
     *
     * @return string
     */
    private function hostingStartDate(): string
    {
        return $this->getPreference('hostingStartDate', '');
    }

    /**
     * hosting Auftragsverarbeitung agreement last date / time             // tbd should be 2 elements date + time
     * e.g. 25.11.2022 um 00:33 Uhr
     *
     * @return string
     */
    private function hostingEndDate(): string
    {
        return $this->getPreference('hostingEndDate', '');
    }

    /**
     * ordered chapters
     * set default values in case the settings are not stored in the database yet
     *
     * @param ServerRequestInterface $request
     * @return array<object> of ordered objects
     */
    private function getChapters(ServerRequestInterface $request): array
    {
        $listChapterKeys = LegalNoticeSupport::listChapterKeys();
        $orderDefault = implode(',', $listChapterKeys);
        $order = explode(',', $this->getPreference('order', $orderDefault));

        if (count($listChapterKeys) > count($order)) {
            $this->addChapters($listChapterKeys, $order);
        }

        $parameters = LegalNoticeSupport::getChapterParameters();
        $privacyLawRegion = $this->privacyLawRegion();
        $chapterTexts = LegalNoticeSupport::getChapterContent(
            LegalNoticeSupport::getHostName($request),
            I18N::translate($this->hostingCountry()),
            $this->showDisputeResolution() && $privacyLawRegion !== self::PRIVACY_LAW_OTHER,
            $privacyLawRegion === self::PRIVACY_LAW_GERMANY
        );

        $chaptersList = [];
        foreach ($order as $chapterKey) {
            $parameter = $parameters[$chapterKey];
            $chapterText = $chapterTexts[$chapterKey];
            if (count($chapterText) > 0) {
                $chapterObj = new Chapter(
                    $chapterKey,
                    $parameter['id'],
                    $parameter['heading'],
                    $parameter['level'],
                    $parameter['link'],
                    $this->getPreference('status-' . $chapterKey, 'on') == 'on',
                    $chapterText['contentIWe'],
                    ($chapterText['contentIWe'] ? ($this->useSingularStyle($request) ? $chapterText['contentI'] : $chapterText['contentWe']) : $chapterText['content'])
                );
                $chaptersList[$chapterKey] = $chapterObj;
            }
        }
        return $chaptersList;
    }

    /**
     * add chapters, which are newly defined
     * tbd: it is not possible to delete chapters, only add new ones
     *
     * @param array $listChapters list of chapters defined by this module
     * @param array $order list of ordered chapters out of parameters
     */
    private function addChapters(array $listChapters, array &$order)
    {

        foreach ($listChapters as $chapter) {
            if (!in_array($chapter, $order)) {
                $order[] = $chapter;                 // add new chapters at the end of the list
            }
        }
    }

    /**
     * is a specific chapter enabled?
     *
     * @param string $chapterKey
     * @param ServerRequestInterface $request
     * @return bool
     */
    private function isChapterEnabled(string $chapterKey, ServerRequestInterface $request): bool
    {
        $enabled = false;
        $chapters = $this->getChapters($request);
        foreach ($chapters as $chapter) {
            if ($chapter->getKey() == $chapterKey) {
                $enabled = $chapter->getEnabled();
            }
        }
        return $enabled;
    }

    /**
     * is the I style used (true) or the We style (false)?
     *
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function useSingularStyle(ServerRequestInterface $request): bool
    {
        return false;                // tbd
        $contactsListObject = new ContactsList($this->userService, $request);
        $count = 0;
        foreach ($contactsListObject->getAdministratorsList() as $admin) {
            $count++;
            if ($count >= 1) {
                return false;
            }
        }
        return true;
    }
};
