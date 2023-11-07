# Hale

Hale is the WordPress Theme based on Gutenberg and designed to run on [Hale Platform](https://github.com/ministryofjustice/hale-platform).  

## Translation files

There are certain websites on Hale which need Welsh support.  Whilst the content might be written separately, there are a few hard-coded elements which need translating.  

The translation files are:

    hale\languages\cy.po
    hale\languages\cy.mo
    
The first of these is the one edited, described below.  The second iis the one compiled by the compile script.

The file we are using here has been adapted from one provided by WordPress, so it will have many translations from there.  These can be edited or removed if need-be, but as they are accurate translations, we have left them in.  

This file is an override, it can be used to override the English.  

The English phrase to be overwritten must be echoed out in a suitable PHP function.

For example:

```
echo __("text to translate","hale");
_e("text to translate","hale");
echo esc_html__("text to translate","hale");
esc_html_e("text to translate","hale");
```

The hale translation file will only affect English phrases declared in this way - so the backend interface will not be affected by these translations.

To update or add translations, we manually edit this file.  

For example:

    msgid "Back"
    msgstr "Yn ôl"

The English (msgid) also acts as a primary key - it is identical with the english that is on the site. The Welsh (msgstr) is returned when the language of the site is set to Welsh in General Settings. 

<img width="698" alt="image" src="https://github.com/ministryofjustice/wp-hale/assets/32877315/0fdd4392-ea8a-4f3f-839e-df9eddfc1057">

Often, there will be a line commented out above each translation, detailing which file the English can be found in.  

## Markup in translation

If a full sentence is wrapped in an HTML tag, this should be without the trans tags.  

For example:

    <p class="govuk-body">
        <?php _e("Jackdaws love my big sphinx of quartz","hale"); ?>
    </p>

However, if the markup appears mid-sentence, this should be included in the translation.  

For example:

    <p class="govuk-body">
        <?php esc_html_e("Jackdaws love <em>my</em> big sphinx of quartz","hale"); ?>
    </p>

If the markup has quotes in it, you can either escape the quotes or use single quotes.  

For example:

    msgid "The <abbr title=\"Ministry of Justice\">MoJ</abbr>"
    msgstr "Y <abbr title=\"Weinyddiaeth Cyfiawnder\">MoJ</abbr>"

Some characters, such as the `%` sign, cause problems.  Always use the HTML code for this symbol and any others that cause issues.  

    __("Zoom in up to 300&#37;","hale");

    msgid "Zoom in up to 300&#37;"
    msgstr "Zoom in up to 300&#37;"

## Links

Often, links appear mid sentence.  There are a number of things to consider with links.  If using the above approach, they can become ungainly, especially in the midst of long sentences.  However, this approach will still work and is sometimes required.  

    esc_html_e("Click <a class='govuk-link' href='url/to/mysterious/website.html' rel='external'>here</a> to go to a mysterious website.,"hale");
    
    msgid "Click <a class='govuk-link' href='url/to/mysterious/website.html' rel='external'>here</a> to go to a mysterious website."
    msgstr "Cliciwch <a class='govuk-link' href='url/to/mysterious/website.html' rel='external'>yma</a> i fynd i wefan ddirgel."

But if the website in question has a Welsh version, we should link to the Welsh in the translation

    msgid "Click <a class='govuk-link' href='url/to/mysterious/website.html' rel='external'>here</a> to go to a mysterious website."
    msgstr "Cliciwch <a class='govuk-link' href='url/to/mysterious/website.html?lang=cymraeg' rel='external'>yma</a> i fynd i wefan ddirgel."

**You should check all URLs at point of translation to see if there is a Welsh version of the website you're linking to.**

If there is no Welsh version to link to, then you should consider using a variable which is easier to maintain should the URL change. This is done by a variable `%s`.

    printf(
        __(
        "Click <a class='govuk-link' href='%s' rel='external'>here</a> to go to a mysterious website.",
        "hale"
      ),
      esc_url('url/to/mysterious/website.html')
    );

    msgid "Click <a class='govuk-link' href='%s' rel='external'>here</a> to go to a mysterious website."
    msgstr "Cliciwch <a class='govuk-link' href='%s' rel='external'>yma</a> i fynd i wefan ddirgel."

## Translation quality

When updating the translation file, it is important to maintain the quality of the text.  

- Ensure that all text uses smart quotes (`’` instead of `'`).
- Ensure all abbreviations are wrapped in `<abbr>` tags.
- - If it isn't obvious from context, expand the abbreviations with their meaning by adding a `title` attribute (e.g. `<abbr title='Legal Aid Agency'>LAA</abbr>`).
- - The abbreviation doesn't need to change with Welsh, e.g. `<abbr title='Asiantaeth Cymorth Cyfreithiol'>LAA</abbr>`.

Ensure that both the English on the HTML page and the Welsh translations are of good quality.

By their nature, these elements cannot be changed by the individual site editors, therefore the Website Builder team's content designers are responsible for this content.  If you think there is poor wording or something should be rephrased, defer to them.  They will decide whether or not the Welsh needs to be redone - but often, if neither the meaning nor the emphasis of the sentence has changed, the Welsh will not need to be altered.  

If you are writing in a different language (e.g. English in the Welsh translation), mark it accordingly with markup.

    msgid "This guide is also available in Welsh (<span lang='cy'>yn Cymraeg</span>)"
    msgstr "Mae’r canllaw hwn hefyd ar gael yn Saes (<span lang='en'>in English</span>)"

## One to many translations

**At time of writing, we don't have any 1:∞ translations, so this has not been developed much**

Occasionally, a single English word required a number of Welsh translations.  This is the case with the word "Yes".  

There are many (at least four) translations for "yes".

- Iawn
- Ydy
- Oes
- Ydw

The word "iawn" is the default word for Yes, and this is handled in the usual way:

    msgid "Yes"
    msgstr "Iawn"

This translation already exists in the WordPress translation file that we've copied.

For all the others, we have to mark it as being used in a certain context.  We do this with a `msgctxt` tag.

    msgctxt "There is/are"
    msgid "Yes"
    msgstr "Oes"

These are then called in a different way, by using the context function.

For example:

```
  echo _x( 'Yes', 'There is/are', 'hale' );
```

The `esc_html_x()` function can be used to escape HTML if needed.

The following variations of yes/no are not an exhaustive list, but these ones already exist in the translations file (we stole them from CLA Public - a fully translated MoJ service).

| English     | Specific Context  | Welsh       |
| ----------- | ----------------- | ----------- |
| Yes         |                   | Iawn        |
| Yes         | I am              | Ydw         |
| Yes         | There is/are      | Oes         |
| Yes         | It is             | Ydy         |
| No          |                   | Na          |
| No          | I’m not           | Nac ydw     |
| No          | There is/are not  | Nac oes     |
| No          | It isn’t          | Nac ydy     |

## Edge cases (method of last resort)

If for whatever reason, we cannot use this approach, we can still hard-code translations using the page locale.

For example:

```
    <?php if (get_locale() == 'cy') { ?>
        Gwall:
    <?php } else { ?>
        Error:
   <?php } ?>
```

If you use this approach, always check for Welsh, and if that returns false, assume the language is English.

