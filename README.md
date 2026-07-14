# ⚖️ **webtrees** module for Legal Notice and Privacy Policy (hh_legal_notice)

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0)

![webtrees major version](https://img.shields.io/badge/webtrees-v2.1.x-green) ![webtrees major version](https://img.shields.io/badge/webtrees-v2.2.x-green)

![Latest Release](https://img.shields.io/github/v/release/hartenthaler/hh_legal_notice)
![Downloads](https://img.shields.io/github/downloads/hartenthaler/hh_legal_notice/total)

This [webtrees](https://www.webtrees.net) module adds a footer link to a legal notice and privacy policy page.

Current module version: **2.2.6.7**.

> [!IMPORTANT]
> This module does not provide legal advice.
> You, as administrator of your website, remain responsible for checking and maintaining the legal notice and privacy policy shown on your site (in all languages provided by this module).
> If necessary, you can fork this module and adapt it to your needs.

There is a German [manual page](https://wiki.genealogy.net/Webtrees_Handbuch/Anleitung_f%C3%BCr_Webmaster/Erweiterungsmodule/Legal_Notice) available, too.

<a name="Contents"></a>
## 📚 Contents

This README contains the following main sections:

* [Purpose](#Purpose)
* [Scope](#Scope)
* [What's new](#WhatsNew)
* [Screenshots](#Screenshots)
* [Requirements](#Requirements)
* [Installation](#Installation)
* [Upgrade](#Upgrade)
* [Contributing](#Contributing)
* [Translation](#Translation)
* [Credits](#Credits)
* [Privacy, telemetry, and tracking](#Privacy)
* [Contact Support](#Support)
* [License](#License)

<a name="Purpose"></a>
## 🎯 Purpose

This module adds a footer link to a legal notice and privacy policy page on all pages of a webtrees site.

Whether a webtrees website legally requires a legal notice or privacy policy depends on your local law and on the character of your site, for example whether it is purely private or publicly accessible.
When in doubt, consult a qualified lawyer in your jurisdiction.

There may be a need to present a legal notice on your website:
* Germany: [§ 5 Digitale-Dienste-Gesetz (DDG)](https://lxgesetze.de/ddg/5) and [§ 4 Medienstaatsvertrag (MStV)](https://lxgesetze.de/mstv/4)
* Austria: § 5 Abs. 1 E-Commerce-Gesetz (ECG)
* Switzerland: Art. 3 des Bundesgesetzes gegen den unlauteren Wettbewerb (UWG)

<a name="Scope"></a>
## 🔎 Scope

The generated page is structured into three parts:
* **Legal Notice** with the provider and contact details; this part is always shown.
* **Privacy Policy** with several configurable sections; this chapter is optional.
* **Legal Regulations** with several configurable sections; this chapter is optional.

The optional chapters and their sections can be reordered and individually enabled or disabled.
There are two styles provided for those sections: "I" style and "We" style,
depending on the number of website administrators.

### Legal Notice
The legal notice is a mandatory part of the legal notice and privacy policy.

The webtrees admin can define the following data fields in the control panel for the provider named in the legal notice
* name of provider
* name of genealogical club or organization
* address
* phone and fax numbers
* email address (with or without subject and body of email)
* VAT ID number or other registration number (like a club registration number)

The webtrees admin can choose if the list of genealogical and technical contact persons for a tree should be shown with their contact links.
If a tree contact or website administrator is the same person as the provider named in the legal notice,
the module avoids showing this person as a separate additional contact.
Instead, the relevant contact role is shown directly below the provider as an additional role.

The webtrees admin can choose if the following additional parts should be shown
* image of the provider using the [Gravatar](https://gravatar.com/)
* editorial responsibility notice according to the German law § 18 Abs. 2 MStV, where applicable
* copyright notice in the footer

### Privacy Policy

The administrator can also configure the server location, hosting provider, supervisory authority,
third-party services, and whether registered users are relatives or relatives by marriage.

The generated privacy policy can include, depending on the configuration and server location:
* a named competent supervisory authority with URL
* references to German, European, or no specific regional data-protection law
* legal bases for processing under the GDPR where EU law applies
* configurable research purpose wording for family research, one-name studies, local family books, farmstead research, thematic research, migration research, community research, or webtrees and genealogical test data
* when the optional `hh-family-trees-list` module is enabled and exposes its public research-purpose API, the settings page shows the configured purposes grouped by frequency together with the corresponding family-tree names
* data protection contact information referring to the provider named in the legal notice
* information about hosting, structured order-processing agreement dates, application logs, third-party services, tracking and analytics, and third-country transfers
* information about retention periods for inactive user accounts
* information that registered users can view, correct, or delete account data in their profile settings
* information about the long-term preservation of genealogical data as historically relevant material
* information about special categories of genealogical personal data and their protection period after death
* optional consumer dispute resolution notice for websites based on German law
* additional third-party services can be configured by the administrator using service name, URL, and optional country of service provision. If the website is subject to EU data-protection law and a configured service is provided from outside the European Union, the generated privacy policy can include a third-country-transfer notice.
* the privacy-policy page can also include information from other installed modules. Compatible modules can expose a public `privacyNotices(): array` method with third-party services and security measures. The complete contract for supplying modules, field definitions, translation guidance, and a PHP example are documented in [`docs/privacy-notices-contract.md`](docs/privacy-notices-contract.md). This is used, for example, by `hh_source_transcription` for external transcription providers such as Transkribus or Discourse. Active webtrees map providers and map links can also be detected and listed as third-party services.


For special categories of personal data, such as religious affiliation, political affiliation,
genetic data, health data, or causes of death, the administrator can configure a protection period
from 0 to 100 years after death. The default is 10 years.

### Legal Regulations

The legal-regulations chapter can include notices about copyright, distribution of genealogical data,
automated collection, scraping, data mining, AI-system use, technical measures against unwanted
automated access, and copyright enforcement.

<a name="WhatsNew"></a>
## ✨ What's new in 2.2.6.7

This release improves the generated privacy policy page:

* A new privacy-policy section explains that exported data is no longer protected by the technical protection mechanisms of webtrees.
* The section covers GEDCOM exports, reports, and screenshots, including the role-based visibility settings that can apply before data leaves webtrees.
* The German translation has been updated for the new data-export wording.

## ✨ What's still open

The remaining open topic is documentation for cookies and for obtaining consent before tracking services or website tools are used.
This depends on related improvements in webtrees itself, which need to be resolved first.

<a name="Screenshots"></a>
## 🖼 Screenshots

The screenshots show sample views of the Legal Notice and Privacy Policy pages.
Both the configuration menu and the generated page content depend on the module settings and on the options selected in webtrees.

Screenshot of Legal Notice footer
<p align="center"><img src="docs/img/legal_notice_footer_english.jpg" alt="Screenshot of Legal Notice footer in English" align="center" width="60%"></p>

Screenshot of Legal Notice page
<p align="center"><img src="docs/img/legal_notice_legal_notice_english.jpg" alt="Screenshot of Legal Notice page in English" align="center" width="80%"></p>

Screenshot of Privacy Policy page
<p align="center"><img src="docs/img/legal_notice_legal_data_protection_english.jpg" alt="Screenshot of Privacy Policy page in English" align="center" width="80%"></p>

Screenshot of Legal Regulations page
<p align="center"><img src="docs/img/legal_notice_legal_regulations_english.jpg" alt="Screenshot of Legal Regulations page in English" align="center" width="80%"></p>

Screenshot of control panel sections
<p align="center"><img src="docs/img/legal_notice_control_panel_sections_english.jpg" alt="Screenshot of control panel sections in English" align="center" width="80%"></p>

Screenshot of control panel details
<p align="center"><img src="docs/img/legal_notice_control_panel_details_english.jpg" alt="Screenshot of control panel details in English" align="center" width="80%"></p>

<a name="Requirements"></a>
## 📌 Requirements

This module requires **webtrees** version 2.1 or 2.2.
This module has the same requirements as [webtrees#system-requirements](https://github.com/fisharebest/webtrees#system-requirements).

This module was tested with **webtrees** version 2.2.6.

<a name="Installation"></a>
## 📥 Installation

This section documents installation instructions for this module.

Install and use [Custom Module Manager](https://github.com/Jefferson49/CustomModuleManager) for an easy and convenient installation of **webtrees** custom modules.
* Open the Custom Module Manager view in **webtrees**, scroll to "Legal Notice and Privacy Policy", and click the "Install Module" button.

**Manual installation**:

1. Make a database backup.
1. Download the [latest release](https://github.com/hartenthaler/hh_legal_notice/releases/latest).
1. Unzip the package into your `webtrees/modules_v4` directory of your web server.
1. Rename the folder to `hh_legal_notice`.

**Finish installation**:
* Login to **webtrees** as administrator, go to <span class="pointer">Control Panel/Modules/Website/Footers</span>, and find the module. It will be called "Legal Notice and Privacy Policy".
* Click the wrench icon and add all desired information fields.
* Finally, click Save to complete the installation.
* You may want to deactivate the core footer module "contact information" if this module already shows the desired contact information.

<a name="Upgrade"></a>
## ⬆️ Upgrade

To update simply replace the `hh_legal_notice` files
with the new ones from the latest release.

### Upgrading from the former hh_imprint module
- Do NOT delete the module settings of the former `hh_imprint` module before the installation of `hh_legal_notice`.
- Delete the folder `hh_imprint` in your `webtrees/modules_v4` directory.
- Install the `hh_legal_notice` module as described in [Installation](#Installation).
- Open the Control Panel page of this footer module; `hh_legal_notice` will take over the existing settings from `hh_imprint`. You should see a notice.
- After `hh_legal_notice` has migrated the settings, `hh_imprint` can be removed and the related settings can be deleted (follow the message in the control panel after deletion of the module).

<a name="Contributing"></a>
## 🤝 Contributing

If you'd like to contribute to this module, great! You can contribute by

- Reading and commenting the legal chapters carefully - choose a specific topic and please [create an issue](https://github.com/hartenthaler/hh_legal_notice/issues) for that topic.
- Contributing code - check out the issues for things that need attention. If you have changes you want to make not listed in an issue, please create one, then you can link your pull request.
- Testing - it's all manual currently, please [create an issue](https://github.com/hartenthaler/hh_legal_notice/issues) for any bugs you find.

<a name="Translation"></a>
## 🌍 Translation

In addition to English, the following languages are available:
- Catalan (by Bernat Josep Banyuls i Sala)
- Dutch (by TheDutchJewel)
- German (by Hermann Hartenthaler)

You can use a local editor,
like Poedit or Notepad++ to make the translations and send them back to me.
You can do this via a pull request (if you know how) or by e-mail.
Discussion on translating can be done by creating an [issue](https://github.com/hartenthaler/hh_legal_notice/issues).

Updated translations will be included in the next release of this module.

<a name="Credits"></a>
## 🙏 Credits

Developed by Hermann Hartenthaler with support from OpenAI Codex and JetBrains PhpStorm.

The module is based on ideas and earlier work from Josef Prause's `jp-privacy-policy` module and related webtrees community discussions.

<a name="Privacy"></a>
## 🔒 Privacy, telemetry, and tracking

This module does not collect analytics data, does not track users, and does not send any data to the module author.

When the **webtrees** control panel is opened, the module checks whether a newer version is available. This version check requests only the module's public latest-version URL on `github.com`.

The module can optionally show an image of the provider through [Gravatar](https://gravatar.com/). If this option is enabled, the visitor's browser requests an image from `www.gravatar.com`; the configured e-mail address is used only as a hash in the Gravatar image URL. Gravatar may process the visitor's IP address and normal browser request metadata. The generated privacy policy can list Gravatar as a third-party service and can mention possible third-country transfer where EU data-protection law applies.

<a name="Support"></a>
## ❓ Support

**Issues**: for any ideas you have, or when finding a bug you can raise an [issue](https://github.com/hartenthaler/hh_legal_notice/issues).

**Forum**: general webtrees support can be found at the [webtrees forum](http://www.webtrees.net/).

<a name="License"></a>
## 📄 License

* Copyright (C) 2026 Hermann Hartenthaler
* Derived from **webtrees** - Copyright 2026 webtrees development team.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

* * *
