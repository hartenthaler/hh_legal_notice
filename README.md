# ⚖️ **webtrees** module for Legal Notice and Privacy Policy (hh_legal_notice)

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0)

![webtrees major version](https://img.shields.io/badge/webtrees-v2.1.x-green) ![webtrees major version](https://img.shields.io/badge/webtrees-v2.2.x-green)

![Latest Release](https://img.shields.io/github/v/release/hartenthaler/hh_legal_notice)

This [webtrees](https://www.webtrees.net) module adds a footer link to a legal notice and privacy policy page.

Current module version: **2.2.6.2**.

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

The webtrees admin can define the following data fields in the control panel for the responsible person
* name of responsible person
* name of genealogical club or organization
* address
* phone and fax numbers
* eMail address (with or without subject and body of eMail)
* VAT ID number or other registration number (like a club registration number)

The webtrees admin can choose if the following additional parts should be shown
* copyright notice in the footer
* image of the responsible person using the [Gravatar](https://gravatar.com/)
* list of contact persons for a tree (genealogical and technical)
* list of administrators of this site with their contact links
* editorial responsibility notice according to § 18 Abs. 2 MStV, where applicable
* optional consumer dispute resolution notice for websites whose server is located in the European Union

The generated page is structured into three parts:
* **Legal Notice** with the responsible person and contact details; this part is always shown.
* **Privacy Policy** with several configurable sections; this chapter is optional.
* **Legal Regulations** with several configurable sections; this chapter is optional.

The optional chapters and their sections can be reordered and individually enabled or disabled.
There are two styles provided for those sections: "I" style and "We" style,
depending on the number of website administrators.

If a tree contact or website administrator is the same person as the responsible person named in the legal notice,
the module avoids showing this person as a separate additional contact.
Instead, the relevant contact role is shown directly below the responsible person.

The administrator can also configure the server location, hosting provider, supervisory authority,
third-party services, and whether registered users are relatives or relatives by marriage.

The generated privacy policy can include, depending on the configuration and server location:
* references to German, European, or no specific regional data-protection law
* legal bases for processing under the GDPR where EU law applies
* a named competent supervisory authority with URL
* data protection contact information referring to the responsible person named in the legal notice
* information about hosting, structured order-processing agreement dates, application logs, third-party services, tracking and analytics, and third-country transfers
* information about retention periods for inactive user accounts
* information about the long-term preservation of genealogical data as historically relevant material
* information about external transcription providers when compatible modules provide such notices

The legal-regulations chapter can include notices about copyright, distribution of genealogical data,
automated collection, scraping, data mining, AI-system use, and copyright enforcement.

<a name="WhatsNew"></a>
## ✨ What's new in 2.2.6.2

This release expands the legal notice and privacy policy configuration in several areas:

* More flexible section ordering and visibility controls, especially within the privacy policy.
* Improved rendering and styling for heading levels and dark themes.
* A dedicated tracking and analytics disclosure with service details and third-country-transfer handling.
* Configurable retention wording for inactive user accounts, including an admin-side decision aid.
* Structured date fields and validation for hosting order-processing agreements.
* Optional editorial responsibility notice for public editorial content, with § 18 Abs. 2 MStV wording for German legal notices.
* Additional copyright wording covering automated collection, scraping, data mining, and AI-system use.

<a name="Screenshots"></a>
## 🖼 Screenshots

Screenshot of Legal Notice footer (in German language)
<p align="center"><img src="docs/img/legal_notice_footer.png" alt="Screenshot of Legal Notice" align="center" width="60%"></p>

Screenshot of Legal Notice (in German language)
<p align="center"><img src="docs/img/legal_notice.png" alt="Screenshot of Legal Notice" align="center" width="80%"></p>

Screenshot of control panel page (in German language)
<p align="center"><img src="docs/img/legal_notice_control_panel.png" alt="Screenshot of control panel menu" align="center" width="80%"></p>

<a name="Requirements"></a>
## 📌 Requirements

This module requires **webtrees** version 2.1 or 2.2.
This module has the same requirements as [webtrees#system-requirements](https://github.com/fisharebest/webtrees#system-requirements).

This module was tested with **webtrees** version 2.2.6.

<a name="Installation"></a>
## 📥 Installation

This section documents installation instructions for this module.

Install and use [Custom Module Manager](https://github.com/Jefferson49/CustomModuleManager) for an easy and convenient installation of **webtrees** custom modules.
- Open the Custom Module Manager view in **webtrees**, scroll to "Legal Notice and Privacy Policy", and click the "Install Module" button.

**Manual installation**:

1. Make a database backup.
1. Download the [latest release](https://github.com/hartenthaler/hh_legal_notice/releases/latest).
1. Unzip the package into your `webtrees/modules_v4` directory of your web server.
1. Rename the folder to `hh_legal_notice`.
1. Login to **webtrees** as administrator, go to <span class="pointer">Control Panel/Modules/Website/Footers</span>, and find the module. It will be called "Legal Notice and Privacy Policy". Check if it has a tick for "Enabled".
1. Click at the wrench symbol and add all desired information fields.
1. Finally, click SAVE, to complete the installation.

After installation, you may want to deactivate the core footer module "contact information" if this module already shows the desired contact information.

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

You can use a local editor,
like Poedit or Notepad++ to make the translations and send them back to me.
You can do this via a pull request (if you know how) or by e-mail.

Discussion on translating can be done by creating an [issue](https://github.com/hartenthaler/hh_legal_notice/issues).

Updated translations will be included in the next release of this module.

In addition to English, the following languages are available:
- Catalan (by Bernat Josep Banyuls i Sala)
- Dutch (by TheDutchJewel)
- German (by Hermann Hartenthaler)

<a name="Credits"></a>
## 🙏 Credits

Developed by Hermann Hartenthaler with support from OpenAI Codex and JetBrains PhpStorm.

The module is based on ideas and earlier work from Josef Prause's `jp-privacy-policy` module and related webtrees community discussions.

<a name="Privacy"></a>
## 🔒 Privacy, telemetry, and tracking

This module does not collect analytics data, does not track users, and does not send legal-notice content, family tree data, media files, or personal data to the module author.

When the **webtrees** control panel is opened, the module checks whether a newer version is available. This version check requests only the module's public latest-version URL on `github.com`.

The module can optionally show an image of the responsible person through [Gravatar](https://gravatar.com/). If this option is enabled, the visitor's browser requests an image from `www.gravatar.com`; the configured e-mail address is used only as a hash in the Gravatar image URL. Gravatar may process the visitor's IP address and normal browser request metadata. The generated privacy policy can list Gravatar as a third-party service and can mention possible third-country transfer where EU data-protection law applies.

The generated privacy policy can also mention [Google Charts](https://developers.google.com/chart) when the administrator enables this option and the webtrees statistics chart module is active. Google Charts may be loaded from Google servers when statistics charts are viewed.

Additional third-party services can be configured by the administrator using service name, URL, and optional country of service provision. If the website is subject to EU data-protection law and a configured service is provided from outside the European Union, the generated privacy policy can include a third-country-transfer notice.

The privacy-policy page can also include information from other installed modules. For example, if `hh_source_transcription` is installed, this module can show privacy information about external transcription providers such as Transkribus or Discourse.

The wording for the webtrees core cookie behavior is being clarified separately; see issue [#48](https://github.com/hartenthaler/hh_legal_notice/issues/48).

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
