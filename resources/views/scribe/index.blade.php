<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>PeopleOS Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('/vendor/scribe/css/theme-default.style.css') }}" media="screen" />
    <link rel="stylesheet" href="{{ asset('/vendor/scribe/css/theme-default.print.css') }}" media="print" />

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css" />
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
      /* starts out as display none and is replaced with js later  */
      body .content .bash-example code {
        display: none;
      }
      body .content .javascript-example code {
        display: none;
      }
      body .content .php-example code {
        display: none;
      }
    </style>

    <script src="{{ asset('/vendor/scribe/js/theme-default-4.38.0.js') }}"></script>
  </head>

  <body data-languages='["bash","javascript","php"]'>
    <a href="#" id="nav-button">
      <span>
        MENU
        <img src="{{ asset('/vendor/scribe/images/navbar.png') }}" alt="navbar-image" />
      </span>
    </a>
    <div class="tocify-wrapper">
      <div class="lang-selector">
        <button type="button" class="lang-button" data-language-name="bash">bash</button>
        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
        <button type="button" class="lang-button" data-language-name="php">php</button>
      </div>

      <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search" />
      </div>

      <div id="toc">
        <ul id="tocify-header-introduction" class="tocify-header">
          <li class="tocify-item level-1" data-unique="introduction">
            <a href="#introduction">Introduction</a>
          </li>
        </ul>
        <ul id="tocify-header-authenticating-requests" class="tocify-header">
          <li class="tocify-item level-1" data-unique="authenticating-requests">
            <a href="#authenticating-requests">Authenticating requests</a>
          </li>
        </ul>
        <ul id="tocify-header-companies" class="tocify-header">
          <li class="tocify-item level-1" data-unique="companies">
            <a href="#companies">Companies</a>
          </li>
          <ul id="tocify-subheader-companies" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="companies-GETapi-vaults--vault--companies">
              <a href="#companies-GETapi-vaults--vault--companies">List all companies.</a>
            </li>
            <li class="tocify-item level-2" data-unique="companies-POSTapi-vaults--vault--companies">
              <a href="#companies-POSTapi-vaults--vault--companies">Create a company.</a>
            </li>
            <li class="tocify-item level-2" data-unique="companies-PUTapi-vaults--vault--companies--company-">
              <a href="#companies-PUTapi-vaults--vault--companies--company-">Update a company.</a>
            </li>
            <li class="tocify-item level-2" data-unique="companies-DELETEapi-vaults--vault--companies--company-">
              <a href="#companies-DELETEapi-vaults--vault--companies--company-">Delete a company.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-contacts" class="tocify-header">
          <li class="tocify-item level-1" data-unique="contacts">
            <a href="#contacts">Contacts</a>
          </li>
          <ul id="tocify-subheader-contacts" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="contacts-contacts">
              <a href="#contacts-contacts">Contacts</a>
            </li>
            <ul id="tocify-subheader-contacts-contacts" class="tocify-subheader">
              <li class="tocify-item level-3" data-unique="contacts-GETapi-vaults--vault--contacts">
                <a href="#contacts-GETapi-vaults--vault--contacts">List all contacts.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-POSTapi-vaults--vault--contacts">
                <a href="#contacts-POSTapi-vaults--vault--contacts">Create a contact.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-GETapi-vaults--vault--contacts--contact-">
                <a href="#contacts-GETapi-vaults--vault--contacts--contact-">Retrieve a contact.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-PUTapi-vaults--vault--contacts--contact-">
                <a href="#contacts-PUTapi-vaults--vault--contacts--contact-">Update a contact.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-DELETEapi-vaults--vault--contacts--contact-">
                <a href="#contacts-DELETEapi-vaults--vault--contacts--contact-">Delete a contact.</a>
              </li>
            </ul>
            <li class="tocify-item level-2" data-unique="contacts-PUTapi-vaults--vault--contacts--contact--job">
              <a href="#contacts-PUTapi-vaults--vault--contacts--contact--job">Update a contact's job information.</a>
            </li>
            <li class="tocify-item level-2" data-unique="contacts-PUTapi-vaults--vault--contacts--contact--background">
              <a href="#contacts-PUTapi-vaults--vault--contacts--contact--background">Update a contact's background information.</a>
            </li>
            <li class="tocify-item level-2" data-unique="contacts-phone-numbers">
              <a href="#contacts-phone-numbers">Phone Numbers</a>
            </li>
            <ul id="tocify-subheader-contacts-phone-numbers" class="tocify-subheader">
              <li class="tocify-item level-3" data-unique="contacts-GETapi-vaults--vault--contacts--contact--phone-numbers">
                <a href="#contacts-GETapi-vaults--vault--contacts--contact--phone-numbers">List all phone numbers of a contact.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-POSTapi-vaults--vault--contacts--contact--phone-numbers">
                <a href="#contacts-POSTapi-vaults--vault--contacts--contact--phone-numbers">Create a contact phone number.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">
                <a href="#contacts-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">Update a contact phone number.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">
                <a href="#contacts-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">Delete a contact phone number.</a>
              </li>
            </ul>
            <li class="tocify-item level-2" data-unique="contacts-children">
              <a href="#contacts-children">Children</a>
            </li>
            <ul id="tocify-subheader-contacts-children" class="tocify-subheader">
              <li class="tocify-item level-3" data-unique="contacts-GETapi-vaults--vault--contacts--contact--children">
                <a href="#contacts-GETapi-vaults--vault--contacts--contact--children">List all children.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-GETapi-vaults--vault--contacts--contact--children--child-">
                <a href="#contacts-GETapi-vaults--vault--contacts--contact--children--child-">Retrieve a child.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-POSTapi-vaults--vault--contacts--contact--children">
                <a href="#contacts-POSTapi-vaults--vault--contacts--contact--children">Create a child.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-PUTapi-vaults--vault--contacts--contact--children--child-">
                <a href="#contacts-PUTapi-vaults--vault--contacts--contact--children--child-">Update a child.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-DELETEapi-vaults--vault--contacts--contact--children--child-">
                <a href="#contacts-DELETEapi-vaults--vault--contacts--contact--children--child-">Delete a child.</a>
              </li>
            </ul>
            <li class="tocify-item level-2" data-unique="contacts-partners">
              <a href="#contacts-partners">Partners</a>
            </li>
            <ul id="tocify-subheader-contacts-partners" class="tocify-subheader">
              <li class="tocify-item level-3" data-unique="contacts-GETapi-vaults--vault--contacts--contact--partners">
                <a href="#contacts-GETapi-vaults--vault--contacts--contact--partners">List all partners.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-GETapi-vaults--vault--contacts--contact--partners--partner-">
                <a href="#contacts-GETapi-vaults--vault--contacts--contact--partners--partner-">Retrieve a partner.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-POSTapi-vaults--vault--contacts--contact--partners">
                <a href="#contacts-POSTapi-vaults--vault--contacts--contact--partners">Create a partner.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-PUTapi-vaults--vault--contacts--contact--partners--partner-">
                <a href="#contacts-PUTapi-vaults--vault--contacts--contact--partners--partner-">Update a partner.</a>
              </li>
              <li class="tocify-item level-3" data-unique="contacts-DELETEapi-vaults--vault--contacts--contact--partners--partner-">
                <a href="#contacts-DELETEapi-vaults--vault--contacts--contact--partners--partner-">Delete a partner.</a>
              </li>
            </ul>
          </ul>
        </ul>
        <ul id="tocify-header-ethnicities" class="tocify-header">
          <li class="tocify-item level-1" data-unique="ethnicities">
            <a href="#ethnicities">Ethnicities</a>
          </li>
          <ul id="tocify-subheader-ethnicities" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="ethnicities-GETapi-ethnicities">
              <a href="#ethnicities-GETapi-ethnicities">List all ethnicities.</a>
            </li>
            <li class="tocify-item level-2" data-unique="ethnicities-GETapi-ethnicities--ethnicity-">
              <a href="#ethnicities-GETapi-ethnicities--ethnicity-">Retrieve an ethnicity.</a>
            </li>
            <li class="tocify-item level-2" data-unique="ethnicities-POSTapi-ethnicities">
              <a href="#ethnicities-POSTapi-ethnicities">Create an ethnicity.</a>
            </li>
            <li class="tocify-item level-2" data-unique="ethnicities-PUTapi-ethnicities--ethnicity-">
              <a href="#ethnicities-PUTapi-ethnicities--ethnicity-">Update an ethnicity.</a>
            </li>
            <li class="tocify-item level-2" data-unique="ethnicities-DELETEapi-ethnicities--ethnicity-">
              <a href="#ethnicities-DELETEapi-ethnicities--ethnicity-">Delete an ethnicity.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-genders" class="tocify-header">
          <li class="tocify-item level-1" data-unique="genders">
            <a href="#genders">Genders</a>
          </li>
          <ul id="tocify-subheader-genders" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="genders-GETapi-genders">
              <a href="#genders-GETapi-genders">List all genders.</a>
            </li>
            <li class="tocify-item level-2" data-unique="genders-GETapi-genders--gender-">
              <a href="#genders-GETapi-genders--gender-">Retrieve a gender.</a>
            </li>
            <li class="tocify-item level-2" data-unique="genders-POSTapi-genders">
              <a href="#genders-POSTapi-genders">Create a gender.</a>
            </li>
            <li class="tocify-item level-2" data-unique="genders-PUTapi-genders--gender-">
              <a href="#genders-PUTapi-genders--gender-">Update a gender.</a>
            </li>
            <li class="tocify-item level-2" data-unique="genders-DELETEapi-genders--gender-">
              <a href="#genders-DELETEapi-genders--gender-">Delete a gender.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-notes" class="tocify-header">
          <li class="tocify-item level-1" data-unique="notes">
            <a href="#notes">Notes</a>
          </li>
          <ul id="tocify-subheader-notes" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="notes-GETapi-vaults--vault--contacts--contact--notes">
              <a href="#notes-GETapi-vaults--vault--contacts--contact--notes">List all notes.</a>
            </li>
            <li class="tocify-item level-2" data-unique="notes-GETapi-vaults--vault--contacts--contact--notes--note-">
              <a href="#notes-GETapi-vaults--vault--contacts--contact--notes--note-">Retrieve a note.</a>
            </li>
            <li class="tocify-item level-2" data-unique="notes-POSTapi-vaults--vault--contacts--contact--notes">
              <a href="#notes-POSTapi-vaults--vault--contacts--contact--notes">Create a note.</a>
            </li>
            <li class="tocify-item level-2" data-unique="notes-PUTapi-vaults--vault--contacts--contact--notes--note-">
              <a href="#notes-PUTapi-vaults--vault--contacts--contact--notes--note-">Update a note.</a>
            </li>
            <li class="tocify-item level-2" data-unique="notes-DELETEapi-vaults--vault--contacts--contact--notes--note-">
              <a href="#notes-DELETEapi-vaults--vault--contacts--contact--notes--note-">Delete a note.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-profile" class="tocify-header">
          <li class="tocify-item level-1" data-unique="profile">
            <a href="#profile">Profile</a>
          </li>
          <ul id="tocify-subheader-profile" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="profile-GETapi-me">
              <a href="#profile-GETapi-me">Get the information about the logged user.</a>
            </li>
            <li class="tocify-item level-2" data-unique="profile-PUTapi-me">
              <a href="#profile-PUTapi-me">Update your profile.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-templates" class="tocify-header">
          <li class="tocify-item level-1" data-unique="templates">
            <a href="#templates">Templates</a>
          </li>
          <ul id="tocify-subheader-templates" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="templates-GETapi-templates">
              <a href="#templates-GETapi-templates">List all templates.</a>
            </li>
            <li class="tocify-item level-2" data-unique="templates-GETapi-templates--template-">
              <a href="#templates-GETapi-templates--template-">Retrieve a template.</a>
            </li>
            <li class="tocify-item level-2" data-unique="templates-POSTapi-templates">
              <a href="#templates-POSTapi-templates">Create a template.</a>
            </li>
            <li class="tocify-item level-2" data-unique="templates-PUTapi-templates--template-">
              <a href="#templates-PUTapi-templates--template-">Update a template.</a>
            </li>
            <li class="tocify-item level-2" data-unique="templates-DELETEapi-templates--template-">
              <a href="#templates-DELETEapi-templates--template-">Delete a template.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-vaults" class="tocify-header">
          <li class="tocify-item level-1" data-unique="vaults">
            <a href="#vaults">Vaults</a>
          </li>
          <ul id="tocify-subheader-vaults" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="vaults-GETapi-vaults">
              <a href="#vaults-GETapi-vaults">List all vaults.</a>
            </li>
            <li class="tocify-item level-2" data-unique="vaults-POSTapi-vaults">
              <a href="#vaults-POSTapi-vaults">Create a vault.</a>
            </li>
            <li class="tocify-item level-2" data-unique="vaults-GETapi-vaults--vault-">
              <a href="#vaults-GETapi-vaults--vault-">Retrieve a vault.</a>
            </li>
            <li class="tocify-item level-2" data-unique="vaults-PUTapi-vaults--vault-">
              <a href="#vaults-PUTapi-vaults--vault-">Update a vault.</a>
            </li>
            <li class="tocify-item level-2" data-unique="vaults-DELETEapi-vaults--vault-">
              <a href="#vaults-DELETEapi-vaults--vault-">Delete a vault.</a>
            </li>
          </ul>
        </ul>
      </div>

      <ul class="toc-footer" id="toc-footer">
        <li style="padding-bottom: 5px"><a href="{{ route('scribe.postman') }}">View Postman collection</a></li>
        <li style="padding-bottom: 5px"><a href="{{ route('scribe.openapi') }}">View OpenAPI spec</a></li>
        <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
      </ul>

      <ul class="toc-footer" id="last-updated">
        <li>Last updated: December 29, 2024</li>
      </ul>
    </div>

    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
        <h1 id="introduction">Introduction</h1>
        <aside>
          <strong>Base URL</strong>
          :
          <code>http://peopleos.test</code>
        </aside>
        <p>This documentation aims to provide all the information you need to work with our API.</p>
        <aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile). You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>

        <h1 id="authenticating-requests">Authenticating requests</h1>
        <p>
          To authenticate requests, include an
          <strong><code>Authorization</code></strong>
          header with the value
          <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>
          .
        </p>
        <p>
          All authenticated endpoints are marked with a
          <code>requires authentication</code>
          badge in the documentation below.
        </p>
        <p>
          You can retrieve your token by visiting your dashboard and clicking
          <b>Generate API token</b>
          .
        </p>

        <h1 id="companies">Companies</h1>

        <h2 id="companies-GETapi-vaults--vault--companies">List all companies.</h2>

        <p></p>

        <p>This will list all the companies, sorted alphabetically.</p>

        <span id="example-requests-GETapi-vaults--vault--companies">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/1/companies" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/companies"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/companies';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--companies">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">[{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;company&quot;,
 &quot;name&quot;: &quot;Dunder Mifflin&quot;,
}, {
 &quot;id&quot;: 5,
 &quot;object&quot;: &quot;company&quot;,
 &quot;name&quot;: &quot;Wayne Enterprises&quot;,
}]</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--companies" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--companies"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--companies"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--companies" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--companies">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--companies" data-method="GET" data-path="api/vaults/{vault}/companies" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--companies', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/companies</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--companies" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--companies" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--companies" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h2 id="companies-POSTapi-vaults--vault--companies">Create a company.</h2>

        <p></p>

        <span id="example-requests-POSTapi-vaults--vault--companies">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/vaults/1/companies" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Dunder Mifflin\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/companies"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Dunder Mifflin"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/companies';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Dunder Mifflin',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-vaults--vault--companies">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;company&quot;,
 &quot;name&quot;: &quot;Dunder Mifflin&quot;,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-vaults--vault--companies" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-vaults--vault--companies"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-vaults--vault--companies"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-vaults--vault--companies" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-vaults--vault--companies">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-vaults--vault--companies" data-method="POST" data-path="api/vaults/{vault}/companies" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-vaults--vault--companies', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/vaults/{vault}/companies</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-vaults--vault--companies" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-vaults--vault--companies" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="POSTapi-vaults--vault--companies" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-vaults--vault--companies" value="Dunder Mifflin" data-component="body" />
            <br />
            <p>
              The name of the company. Max 255 characters. Example:
              <code>Dunder Mifflin</code>
            </p>
          </div>
        </form>

        <h2 id="companies-PUTapi-vaults--vault--companies--company-">Update a company.</h2>

        <p></p>

        <span id="example-requests-PUTapi-vaults--vault--companies--company-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/companies/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Dunder Mifflin\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/companies/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Dunder Mifflin"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/companies/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Dunder Mifflin',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--companies--company-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;company&quot;,
 &quot;name&quot;: &quot;Dunder Mifflin&quot;,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--companies--company-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--companies--company-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--companies--company-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--companies--company-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--companies--company-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--companies--company-" data-method="PUT" data-path="api/vaults/{vault}/companies/{company}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--companies--company-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/companies/{company}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--companies--company-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--companies--company-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--companies--company-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>company</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="company" data-endpoint="PUTapi-vaults--vault--companies--company-" value="1" data-component="url" />
            <br />
            <p>
              The id of the company. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-vaults--vault--companies--company-" value="Dunder Mifflin" data-component="body" />
            <br />
            <p>
              The name of the company. Max 255 characters. Example:
              <code>Dunder Mifflin</code>
            </p>
          </div>
        </form>

        <h2 id="companies-DELETEapi-vaults--vault--companies--company-">Delete a company.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault--companies--company-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/1/companies/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/companies/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/companies/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-vaults--vault--companies--company-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault--companies--company-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault--companies--company-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault--companies--company-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault--companies--company-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault--companies--company-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault--companies--company-" data-method="DELETE" data-path="api/vaults/{vault}/companies/{company}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault--companies--company-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}/companies/{company}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault--companies--company-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault--companies--company-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault--companies--company-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>company</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="company" data-endpoint="DELETEapi-vaults--vault--companies--company-" value="1" data-component="url" />
            <br />
            <p>
              The id of the company. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="contacts">Contacts</h1>

        <h2 id="contacts-contacts">Contacts</h2>
        <h2 id="contacts-GETapi-vaults--vault--contacts">List all contacts.</h2>

        <p></p>

        <p>This API call returns a paginated collection of contacts that contains 15 items per page.</p>

        <span id="example-requests-GETapi-vaults--vault--contacts">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/harum/contacts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/harum/contacts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/harum/contacts';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;contact&quot;,
 &quot;gender&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;gender&quot;,
  &quot;label&quot;: &quot;Male&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800,
 },
 &quot;ethnicity&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;ethnicity&quot;,
  &quot;label&quot;: &quot;Asian&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800
 },
 &quot;name&quot;: &quot;Michael Scott&quot;,
 &quot;first_name&quot;: &quot;Michael&quot;,
 &quot;last_name&quot;: &quot;Scott&quot;,
 &quot;middle_name&quot;: &quot;Gary&quot;,
 &quot;nickname&quot;: &quot;Mike&quot;,
 &quot;maiden_name&quot;: &quot;Johnson&quot;,
 &quot;patronymic_name&quot;: null,
 &quot;tribal_name&quot;: null,
 &quot;generation_name&quot;: null,
 &quot;romanized_name&quot;: null,
 &quot;nationality&quot;: &quot;American&quot;,
 &quot;prefix&quot;: &quot;Mr.&quot;,
 &quot;suffix&quot;: &quot;Jr.&quot;,
 &quot;can_be_deleted&quot;: 1
}, {
 &quot;id&quot;: 5
 &quot;object&quot;: &quot;contact&quot;,
 &quot;gender&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;gender&quot;,
  &quot;label&quot;: &quot;Male&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800,
 },
 &quot;ethnicity&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;ethnicity&quot;,
  &quot;label&quot;: &quot;Asian&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800
 },
 &quot;name&quot;: &quot;Dwight Schrute&quot;,
 &quot;first_name&quot;: &quot;Dwight&quot;,
 &quot;last_name&quot;: &quot;Schrute&quot;,
 &quot;middle_name&quot;: &quot;Kurt&quot;,
 &quot;nickname&quot;: &quot;Dwight&quot;,
 &quot;maiden_name&quot;: &quot;Schrute&quot;,
 &quot;patronymic_name&quot;: null,
 &quot;tribal_name&quot;: null,
 &quot;generation_name&quot;: null,
 &quot;romanized_name&quot;: null,
 &quot;nationality&quot;: &quot;American&quot;,
 &quot;prefix&quot;: &quot;Mr.&quot;,
 &quot;suffix&quot;: &quot;Sr.&quot;,
 &quot;can_be_deleted&quot;: 1
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/vaults/1/contacts?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/vaults/1/contacts?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/vaults/1/contacts?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/vaults/1/contacts&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts" data-method="GET" data-path="api/vaults/{vault}/contacts" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts" value="harum" data-component="url" />
            <br />
            <p>
              The vault. Example:
              <code>harum</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;contact&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The gender object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>ethnicity</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The ethnicity object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The display name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>first_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The first name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>last_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The last name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>middle_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The middle name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nickname</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The nickname of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>maiden_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The maiden name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>patronymic_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The patronymic name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>tribal_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The tribal name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>generation_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The generation name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>romanized_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The romanized name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nationality</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The nationality of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>prefix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The prefix of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>suffix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The suffix of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>can_be_deleted</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Whether the contact can be deleted.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-POSTapi-vaults--vault--contacts">Create a contact.</h2>

        <p></p>

        <p>Creates a new contact in the vault.</p>
        <p>You can choose to mark a contact as deletable or not.</p>
        <p>Once created, the contact will be returned in the response, as well as the display name of the contact. This name's format depends on the user settings.</p>

        <span id="example-requests-POSTapi-vaults--vault--contacts">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/vaults/1/contacts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"gender_id\": 1,
    \"ethnicity_id\": 1,
    \"marital_status_id\": 1,
    \"first_name\": \"Michael\",
    \"last_name\": \"Scott\",
    \"middle_name\": \"Gary\",
    \"nickname\": \"Mike\",
    \"maiden_name\": \"Johnson\",
    \"patronymic_name\": \"Einarsdóttir\",
    \"tribal_name\": \"Zulu\",
    \"generation_name\": \"俊\",
    \"romanized_name\": \"Wang Junjie\",
    \"nationality\": \"American\",
    \"prefix\": \"Mr.\",
    \"suffix\": \"Jr.\",
    \"can_be_deleted\": true
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "gender_id": 1,
    "ethnicity_id": 1,
    "marital_status_id": 1,
    "first_name": "Michael",
    "last_name": "Scott",
    "middle_name": "Gary",
    "nickname": "Mike",
    "maiden_name": "Johnson",
    "patronymic_name": "Einarsdóttir",
    "tribal_name": "Zulu",
    "generation_name": "俊",
    "romanized_name": "Wang Junjie",
    "nationality": "American",
    "prefix": "Mr.",
    "suffix": "Jr.",
    "can_be_deleted": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'gender_id' =&gt; 1,
            'ethnicity_id' =&gt; 1,
            'marital_status_id' =&gt; 1,
            'first_name' =&gt; 'Michael',
            'last_name' =&gt; 'Scott',
            'middle_name' =&gt; 'Gary',
            'nickname' =&gt; 'Mike',
            'maiden_name' =&gt; 'Johnson',
            'patronymic_name' =&gt; 'Einarsdóttir',
            'tribal_name' =&gt; 'Zulu',
            'generation_name' =&gt; '俊',
            'romanized_name' =&gt; 'Wang Junjie',
            'nationality' =&gt; 'American',
            'prefix' =&gt; 'Mr.',
            'suffix' =&gt; 'Jr.',
            'can_be_deleted' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-vaults--vault--contacts">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;contact&quot;,
 &quot;gender&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;gender&quot;,
  &quot;label&quot;: &quot;Male&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800,
 },
 &quot;ethnicity&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;ethnicity&quot;,
  &quot;label&quot;: &quot;Asian&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800,
 },
 &quot;name&quot;: &quot;Michael Scott&quot;,
 &quot;first_name&quot;: &quot;Michael&quot;,
 &quot;last_name&quot;: &quot;Scott&quot;,
 &quot;middle_name&quot;: &quot;Gary&quot;,
 &quot;nickname&quot;: &quot;Mike&quot;,
 &quot;maiden_name&quot;: &quot;Johnson&quot;,
 &quot;patronymic_name&quot;: &quot;Einarsd&oacute;ttir&quot;,
 &quot;tribal_name&quot;: &quot;Zulu&quot;,
 &quot;generation_name&quot;: &quot;俊&quot;,
 &quot;romanized_name&quot;: &quot;Wang Junjie&quot;,
 &quot;nationality&quot;: &quot;American&quot;,
 &quot;prefix&quot;: &quot;Mr.&quot;,
 &quot;suffix&quot;: &quot;Jr.&quot;,
 &quot;can_be_deleted&quot;: 1,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-vaults--vault--contacts" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-vaults--vault--contacts"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-vaults--vault--contacts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-vaults--vault--contacts" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-vaults--vault--contacts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-vaults--vault--contacts" data-method="POST" data-path="api/vaults/{vault}/contacts" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-vaults--vault--contacts', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/vaults/{vault}/contacts</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-vaults--vault--contacts" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-vaults--vault--contacts" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="POSTapi-vaults--vault--contacts" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="number" style="display: none" step="any" name="gender_id" data-endpoint="POSTapi-vaults--vault--contacts" value="1" data-component="body" />
            <br />
            <p>
              The gender object associated with the contact. This object must be a valid Gender object. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>ethnicity_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="number" style="display: none" step="any" name="ethnicity_id" data-endpoint="POSTapi-vaults--vault--contacts" value="1" data-component="body" />
            <br />
            <p>
              The ethnicity object associated with the contact. This object must be a valid Ethnicity object. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>marital_status_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="number" style="display: none" step="any" name="marital_status_id" data-endpoint="POSTapi-vaults--vault--contacts" value="1" data-component="body" />
            <br />
            <p>
              The marital status of the contact. This object must be a valid MaritalStatus object. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>first_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="first_name" data-endpoint="POSTapi-vaults--vault--contacts" value="Michael" data-component="body" />
            <br />
            <p>
              The first name of the contact. Max 255 characters. Example:
              <code>Michael</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>last_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="last_name" data-endpoint="POSTapi-vaults--vault--contacts" value="Scott" data-component="body" />
            <br />
            <p>
              The last name of the contact. Max 255 characters. Example:
              <code>Scott</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>middle_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="middle_name" data-endpoint="POSTapi-vaults--vault--contacts" value="Gary" data-component="body" />
            <br />
            <p>
              The middle name of the contact. Max 255 characters. Example:
              <code>Gary</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>nickname</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="nickname" data-endpoint="POSTapi-vaults--vault--contacts" value="Mike" data-component="body" />
            <br />
            <p>
              The nickname of the contact. Max 255 characters. Example:
              <code>Mike</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>maiden_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="maiden_name" data-endpoint="POSTapi-vaults--vault--contacts" value="Johnson" data-component="body" />
            <br />
            <p>
              The maiden name of the contact, important in some cultures, where a woman’s surname changes after marriage. Max 255 characters. Example:
              <code>Johnson</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>patronymic_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="patronymic_name" data-endpoint="POSTapi-vaults--vault--contacts" value="Einarsdóttir" data-component="body" />
            <br />
            <p>
              The patronymic name of the contact, which is the name derived from a parent’s name (common in Icelandic, Russian, and some Arabic cultures). Max 255 characters. Example:
              <code>Einarsdóttir</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>tribal_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="tribal_name" data-endpoint="POSTapi-vaults--vault--contacts" value="Zulu" data-component="body" />
            <br />
            <p>
              The tribal name of the contact, used in various African and Indigenous cultures (e.g., Zulu clan names). Max 255 characters. Example:
              <code>Zulu</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>generation_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="generation_name" data-endpoint="POSTapi-vaults--vault--contacts" value="俊" data-component="body" />
            <br />
            <p>
              The generation name of the contact, often used in Japanese, Chinese, Korean, and Vietnamese culture where part of the name is shared by siblings or cousins to signify their generation. Max 255 characters. Example:
              <code>俊</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>romanized_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="romanized_name" data-endpoint="POSTapi-vaults--vault--contacts" value="Wang Junjie" data-component="body" />
            <br />
            <p>
              The romanized name of the contact, which is the Latin alphabet transliteration of a non-Latin name. Max 255 characters. Example:
              <code>Wang Junjie</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>nationality</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="nationality" data-endpoint="POSTapi-vaults--vault--contacts" value="American" data-component="body" />
            <br />
            <p>
              The nationality of the contact. Max 255 characters. Example:
              <code>American</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>prefix</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="prefix" data-endpoint="POSTapi-vaults--vault--contacts" value="Mr." data-component="body" />
            <br />
            <p>
              The prefix of the contact. Max 255 characters. Example:
              <code>Mr.</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>suffix</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="suffix" data-endpoint="POSTapi-vaults--vault--contacts" value="Jr." data-component="body" />
            <br />
            <p>
              The suffix of the contact. Max 255 characters. Example:
              <code>Jr.</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>can_be_deleted</code></b>
            &nbsp;&nbsp;
            <small>boolean</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <label data-endpoint="POSTapi-vaults--vault--contacts" style="display: none">
              <input type="radio" name="can_be_deleted" value="true" data-endpoint="POSTapi-vaults--vault--contacts" data-component="body" />
              <code>true</code>
            </label>
            <label data-endpoint="POSTapi-vaults--vault--contacts" style="display: none">
              <input type="radio" name="can_be_deleted" value="false" data-endpoint="POSTapi-vaults--vault--contacts" data-component="body" />
              <code>false</code>
            </label>
            <br />
            <p>
              Whether the contact can be deleted. 0 for false, 1 for true. Example:
              <code>true</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;contact&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The gender object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>ethnicity</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The ethnicity object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>marital_status</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The marital status object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The display name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>first_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The first name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>last_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The last name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>middle_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The middle name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nickname</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The nickname of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>maiden_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The maiden name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>patronymic_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The patronymic name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>tribal_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The tribal name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>generation_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The generation name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>romanized_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The romanized name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nationality</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The nationality of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>prefix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The prefix of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>suffix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The suffix of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>can_be_deleted</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Whether the contact can be deleted.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-GETapi-vaults--vault--contacts--contact-">Retrieve a contact.</h2>

        <p></p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/1/contacts/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;object&quot;: &quot;contact&quot;,
    &quot;gender&quot;: {
        &quot;id&quot;: 1,
        &quot;object&quot;: &quot;gender&quot;,
        &quot;label&quot;: &quot;Male&quot;,
        &quot;created_at&quot;: 1514764800,
        &quot;updated_at&quot;: 1514764800
    },
    &quot;ethnicity&quot;: {
        &quot;id&quot;: 1,
        &quot;object&quot;: &quot;ethnicity&quot;,
        &quot;label&quot;: &quot;Asian&quot;,
        &quot;created_at&quot;: 1514764800,
        &quot;updated_at&quot;: 1514764800
    },
    &quot;name&quot;: &quot;John Doe&quot;,
    &quot;first_name&quot;: &quot;John&quot;,
    &quot;last_name&quot;: &quot;Doe&quot;,
    &quot;middle_name&quot;: null,
    &quot;nickname&quot;: null,
    &quot;maiden_name&quot;: null,
    &quot;patronymic_name&quot;: null,
    &quot;tribal_name&quot;: null,
    &quot;generation_name&quot;: null,
    &quot;romanized_name&quot;: null,
    &quot;nationality&quot;: &quot;American&quot;,
    &quot;prefix&quot;: null,
    &quot;suffix&quot;: null,
    &quot;can_be_deleted&quot;: true,
    &quot;created_at&quot;: 1514764800,
    &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact-" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;contact&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp;
          <small>object</small>
          &nbsp; &nbsp;
          <br />
          <p>The gender of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>ethnicity</code></b>
          &nbsp;&nbsp;
          <small>object</small>
          &nbsp; &nbsp;
          <br />
          <p>The ethnicity of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The full name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>first_name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The first name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>last_name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The last name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>middle_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The middle name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nickname</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The nickname of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>maiden_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The maiden name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>patronymic_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The patronymic name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>tribal_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The tribal name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>generation_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The generation name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>romanized_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The romanized name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nationality</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The nationality of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>prefix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The prefix of the contact's name.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>suffix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The suffix of the contact's name.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>can_be_deleted</code></b>
          &nbsp;&nbsp;
          <small>boolean</small>
          &nbsp; &nbsp;
          <br />
          <p>Whether the contact can be deleted.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the contact was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the contact was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-PUTapi-vaults--vault--contacts--contact-">Update a contact.</h2>

        <p></p>

        <p>Updates an existing contact.</p>
        <p>You can choose to mark a contact as deletable or not.</p>
        <p>You can't edit the marital status with this method. Use the partner endpoint to update the marital status.</p>
        <p>Once updated, the contact will be returned in the response, as well as the display name of the contact. This name's format depends on the user settings.</p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--contact-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"gender_id\": 1,
    \"ethnicity_id\": 1,
    \"first_name\": \"Michael\",
    \"last_name\": \"Scott\",
    \"middle_name\": \"Gary\",
    \"nickname\": \"Mike\",
    \"maiden_name\": \"Johnson\",
    \"patronymic_name\": \"Einarsdóttir\",
    \"tribal_name\": \"Zulu\",
    \"generation_name\": \"俊\",
    \"romanized_name\": \"Wang Junjie\",
    \"nationality\": \"American\",
    \"prefix\": \"Mr.\",
    \"suffix\": \"Jr.\",
    \"can_be_deleted\": true
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "gender_id": 1,
    "ethnicity_id": 1,
    "first_name": "Michael",
    "last_name": "Scott",
    "middle_name": "Gary",
    "nickname": "Mike",
    "maiden_name": "Johnson",
    "patronymic_name": "Einarsdóttir",
    "tribal_name": "Zulu",
    "generation_name": "俊",
    "romanized_name": "Wang Junjie",
    "nationality": "American",
    "prefix": "Mr.",
    "suffix": "Jr.",
    "can_be_deleted": true
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'gender_id' =&gt; 1,
            'ethnicity_id' =&gt; 1,
            'first_name' =&gt; 'Michael',
            'last_name' =&gt; 'Scott',
            'middle_name' =&gt; 'Gary',
            'nickname' =&gt; 'Mike',
            'maiden_name' =&gt; 'Johnson',
            'patronymic_name' =&gt; 'Einarsdóttir',
            'tribal_name' =&gt; 'Zulu',
            'generation_name' =&gt; '俊',
            'romanized_name' =&gt; 'Wang Junjie',
            'nationality' =&gt; 'American',
            'prefix' =&gt; 'Mr.',
            'suffix' =&gt; 'Jr.',
            'can_be_deleted' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--contacts--contact-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;contact&quot;,
 &quot;gender&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;gender&quot;,
  &quot;label&quot;: &quot;Male&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800,
 },
 &quot;ethnicity&quot;: {
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;ethnicity&quot;,
  &quot;label&quot;: &quot;Asian&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800,
 },
 &quot;name&quot;: &quot;Michael Scott&quot;,
 &quot;first_name&quot;: &quot;Michael&quot;,
 &quot;last_name&quot;: &quot;Scott&quot;,
 &quot;middle_name&quot;: &quot;Gary&quot;,
 &quot;nickname&quot;: &quot;Mike&quot;,
 &quot;maiden_name&quot;: &quot;Johnson&quot;,
 &quot;patronymic_name&quot;: &quot;Einarsd&oacute;ttir&quot;,
 &quot;tribal_name&quot;: &quot;Zulu&quot;,
 &quot;generation_name&quot;: &quot;俊&quot;,
 &quot;romanized_name&quot;: &quot;Wang Junjie&quot;,
 &quot;nationality&quot;: &quot;American&quot;,
 &quot;prefix&quot;: &quot;Mr.&quot;,
 &quot;suffix&quot;: &quot;Jr.&quot;,
 &quot;can_be_deleted&quot;: 1,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--contacts--contact-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--contact-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--contact-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--contact-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--contact-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--contact-" data-method="PUT" data-path="api/vaults/{vault}/contacts/{contact}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--contact-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{contact}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="number" style="display: none" step="any" name="gender_id" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="1" data-component="body" />
            <br />
            <p>
              The gender object associated with the contact. This object must be a valid Gender object. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>ethnicity_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="number" style="display: none" step="any" name="ethnicity_id" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="1" data-component="body" />
            <br />
            <p>
              The ethnicity object associated with the contact. This object must be a valid Ethnicity object. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>first_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="first_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Michael" data-component="body" />
            <br />
            <p>
              The first name of the contact. Max 255 characters. Example:
              <code>Michael</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>last_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="last_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Scott" data-component="body" />
            <br />
            <p>
              The last name of the contact. Max 255 characters. Example:
              <code>Scott</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>middle_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="middle_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Gary" data-component="body" />
            <br />
            <p>
              The middle name of the contact. Max 255 characters. Example:
              <code>Gary</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>nickname</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="nickname" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Mike" data-component="body" />
            <br />
            <p>
              The nickname of the contact. Max 255 characters. Example:
              <code>Mike</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>maiden_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="maiden_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Johnson" data-component="body" />
            <br />
            <p>
              The maiden name of the contact, important in some cultures, where a woman’s surname changes after marriage. Max 255 characters. Example:
              <code>Johnson</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>patronymic_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="patronymic_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Einarsdóttir" data-component="body" />
            <br />
            <p>
              The patronymic name of the contact, which is the name derived from a parent’s name (common in Icelandic, Russian, and some Arabic cultures). Max 255 characters. Example:
              <code>Einarsdóttir</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>tribal_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="tribal_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Zulu" data-component="body" />
            <br />
            <p>
              The tribal name of the contact, used in various African and Indigenous cultures (e.g., Zulu clan names). Max 255 characters. Example:
              <code>Zulu</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>generation_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="generation_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="俊" data-component="body" />
            <br />
            <p>
              The generation name of the contact, often used in Japanese, Chinese, Korean, and Vietnamese culture where part of the name is shared by siblings or cousins to signify their generation. Max 255 characters. Example:
              <code>俊</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>romanized_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="romanized_name" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Wang Junjie" data-component="body" />
            <br />
            <p>
              The romanized name of the contact, which is the Latin alphabet transliteration of a non-Latin name. Max 255 characters. Example:
              <code>Wang Junjie</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>nationality</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="nationality" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="American" data-component="body" />
            <br />
            <p>
              The nationality of the contact. Max 255 characters. Example:
              <code>American</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>prefix</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="prefix" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Mr." data-component="body" />
            <br />
            <p>
              The prefix of the contact. Max 255 characters. Example:
              <code>Mr.</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>suffix</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="suffix" data-endpoint="PUTapi-vaults--vault--contacts--contact-" value="Jr." data-component="body" />
            <br />
            <p>
              The suffix of the contact. Max 255 characters. Example:
              <code>Jr.</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>can_be_deleted</code></b>
            &nbsp;&nbsp;
            <small>boolean</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <label data-endpoint="PUTapi-vaults--vault--contacts--contact-" style="display: none">
              <input type="radio" name="can_be_deleted" value="true" data-endpoint="PUTapi-vaults--vault--contacts--contact-" data-component="body" />
              <code>true</code>
            </label>
            <label data-endpoint="PUTapi-vaults--vault--contacts--contact-" style="display: none">
              <input type="radio" name="can_be_deleted" value="false" data-endpoint="PUTapi-vaults--vault--contacts--contact-" data-component="body" />
              <code>false</code>
            </label>
            <br />
            <p>
              Whether the contact can be deleted. 0 for false, 1 for true. Example:
              <code>true</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;contact&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The gender object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>ethnicity</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The ethnicity object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The display name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>first_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The first name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>last_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The last name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>middle_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The middle name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nickname</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The nickname of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>maiden_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The maiden name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>patronymic_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The patronymic name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>tribal_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The tribal name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>generation_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The generation name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>romanized_name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The romanized name of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nationality</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The nationality of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>prefix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The prefix of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>suffix</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The suffix of the contact.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>can_be_deleted</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Whether the contact can be deleted.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-DELETEapi-vaults--vault--contacts--contact-">Delete a contact.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault--contacts--contact-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/1/contacts/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-vaults--vault--contacts--contact-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault--contacts--contact-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault--contacts--contact-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault--contacts--contact-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault--contacts--contact-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault--contacts--contact-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault--contacts--contact-" data-method="DELETE" data-path="api/vaults/{vault}/contacts/{contact}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault--contacts--contact-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}/contacts/{contact}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault--contacts--contact-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault--contacts--contact-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault--contacts--contact-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="DELETEapi-vaults--vault--contacts--contact-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-PUTapi-vaults--vault--contacts--contact--job">Update a contact&#039;s job information.</h2>

        <p></p>

        <p>A contact can have one job, linked to a company. You don't need to manually create the company, it will be created if it doesn't exist. This check is done based on the company name.</p>
        <p>If you want a more granular control over the company itself, you can use the dedicated company endpoints.</p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--contact--job">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/1/job" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"job_title\": \"CEO\",
    \"company_name\": \"Dunder Mifflin\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/job"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "job_title": "CEO",
    "company_name": "Dunder Mifflin"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/job';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'job_title' =&gt; 'CEO',
            'company_name' =&gt; 'Dunder Mifflin',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--contacts--contact--job">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;contact&quot;,
    &quot;name&quot;: &quot;Michael Scott&quot;,
    &quot;job_title&quot;: &quot;CEO&quot;,
    &quot;company&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Dunder Mifflin&quot;
    }
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--contacts--contact--job" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--contact--job"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--contact--job"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--contact--job" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--contact--job">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--contact--job" data-method="PUT" data-path="api/vaults/{vault}/contacts/{contact}/job" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--contact--job', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/job</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--contact--job" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--contact--job" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--contact--job" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--contact--job" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>job_title</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="job_title" data-endpoint="PUTapi-vaults--vault--contacts--contact--job" value="CEO" data-component="body" />
            <br />
            <p>
              The job title of the contact. Max 255 characters. Example:
              <code>CEO</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>company_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="company_name" data-endpoint="PUTapi-vaults--vault--contacts--contact--job" value="Dunder Mifflin" data-component="body" />
            <br />
            <p>
              The name of the company. Max 255 characters. Example:
              <code>Dunder Mifflin</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-PUTapi-vaults--vault--contacts--contact--background">Update a contact&#039;s background information.</h2>

        <p></p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--contact--background">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/1/background" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"information\": \"CEO\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/background"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "information": "CEO"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/background';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'information' =&gt; 'CEO',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--contacts--contact--background">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;contact&quot;,
 &quot;name&quot;: &quot;Michael Scott&quot;,
 &quot;background_information&quot;: &quot;Met him at a conference.&quot;,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--contacts--contact--background" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--contact--background"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--contact--background"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--contact--background" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--contact--background">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--contact--background" data-method="PUT" data-path="api/vaults/{vault}/contacts/{contact}/background" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--contact--background', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/background</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--contact--background" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--contact--background" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--contact--background" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--contact--background" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>information</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="information" data-endpoint="PUTapi-vaults--vault--contacts--contact--background" value="CEO" data-component="body" />
            <br />
            <p>
              The background information about the contact. Can be anything, really. Max 255 characters. Example:
              <code>CEO</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-phone-numbers">Phone Numbers</h2>
        <h2 id="contacts-GETapi-vaults--vault--contacts--contact--phone-numbers">List all phone numbers of a contact.</h2>

        <p></p>

        <p>This API call returns a paginated collection of phone numbers that contains 15 items per page.</p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact--phone-numbers">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/ullam/contacts/est/phone-numbers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/ullam/contacts/est/phone-numbers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/ullam/contacts/est/phone-numbers';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact--phone-numbers">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;contact_phone_number&quot;,
 &quot;contact&quot;: {
  &quot;id&quot;: 1,
  &quot;name&quot;: &quot;Michael Scott&quot;
 },
 &quot;label&quot;: &quot;mobile&quot;,
 &quot;phone_number&quot;: &quot;+1234567890&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800
}],
}, {
 &quot;id&quot;: 5
 &quot;object&quot;: &quot;contact_phone_number&quot;,
 &quot;contact&quot;: {
  &quot;id&quot;: 1,
  &quot;name&quot;: &quot;Michael Scott&quot;
 },
 &quot;label&quot;: &quot;mobile&quot;,
 &quot;phone_number&quot;: &quot;+1234567890&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800
 },
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/phone-numbers?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/phone-numbers?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/phone-numbers?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/phone-numbers&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact--phone-numbers" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact--phone-numbers"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact--phone-numbers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact--phone-numbers" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact--phone-numbers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact--phone-numbers" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}/phone-numbers" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact--phone-numbers', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/phone-numbers</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact--phone-numbers" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact--phone-numbers" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact--phone-numbers" value="ullam" data-component="url" />
            <br />
            <p>
              The vault. Example:
              <code>ullam</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact--phone-numbers" value="est" data-component="url" />
            <br />
            <p>
              The contact. Example:
              <code>est</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;contact_phone_number&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The label of the phone number.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>phone_number</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The phone number.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-POSTapi-vaults--vault--contacts--contact--phone-numbers">Create a contact phone number.</h2>

        <p></p>

        <p>A contact can have multiple phone numbers, as many as needed. This number can be a mobile, home, work, fax, etc.</p>

        <span id="example-requests-POSTapi-vaults--vault--contacts--contact--phone-numbers">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/vaults/1/contacts/1/phone-numbers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"nemo\",
    \"phone_number\": \"+1234567890\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/phone-numbers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "nemo",
    "phone_number": "+1234567890"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/phone-numbers';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'nemo',
            'phone_number' =&gt; '+1234567890',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-vaults--vault--contacts--contact--phone-numbers">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;contact_phone_number&quot;,
    &quot;contact&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Michael Scott&quot;
    },
    &quot;label&quot;: &quot;mobile&quot;,
    &quot;phone_number&quot;: &quot;+1234567890&quot;,
    &quot;created_at&quot;: 1724320000,
    &quot;updated_at&quot;: 1724320000
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-vaults--vault--contacts--contact--phone-numbers" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-vaults--vault--contacts--contact--phone-numbers"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-vaults--vault--contacts--contact--phone-numbers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-vaults--vault--contacts--contact--phone-numbers" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-vaults--vault--contacts--contact--phone-numbers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-vaults--vault--contacts--contact--phone-numbers" data-method="POST" data-path="api/vaults/{vault}/contacts/{contact}/phone-numbers" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-vaults--vault--contacts--contact--phone-numbers', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/phone-numbers</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-vaults--vault--contacts--contact--phone-numbers" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-vaults--vault--contacts--contact--phone-numbers" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="POSTapi-vaults--vault--contacts--contact--phone-numbers" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="POSTapi-vaults--vault--contacts--contact--phone-numbers" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>label</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="label" data-endpoint="POSTapi-vaults--vault--contacts--contact--phone-numbers" value="nemo" data-component="body" />
            <br />
            <p>
              The label of the phone number. The current supported labels are mobile, home, work, fax and other. Example:
              <code>nemo</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>phone_number</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="phone_number" data-endpoint="POSTapi-vaults--vault--contacts--contact--phone-numbers" value="+1234567890" data-component="body" />
            <br />
            <p>
              The phone number. Max 255 characters. Example:
              <code>+1234567890</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">Update a contact phone number.</h2>

        <p></p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/1/phone-numbers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"odit\",
    \"phone_number\": \"+1234567890\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/phone-numbers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "odit",
    "phone_number": "+1234567890"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/phone-numbers/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'odit',
            'phone_number' =&gt; '+1234567890',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;contact_phone_number&quot;,
    &quot;contact&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Michael Scott&quot;
    },
    &quot;label&quot;: &quot;mobile&quot;,
    &quot;phone_number&quot;: &quot;+1234567890&quot;,
    &quot;created_at&quot;: 1724320000,
    &quot;updated_at&quot;: 1724320000
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" data-method="PUT" data-path="api/vaults/{vault}/contacts/{contact}/phone-numbers/{contactPhoneNumber}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/phone-numbers/{contactPhoneNumber}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contactPhoneNumber</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="contactPhoneNumber" data-endpoint="PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact phone number. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>label</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="label" data-endpoint="PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="odit" data-component="body" />
            <br />
            <p>
              The label of the phone number. The current supported labels are mobile, home, work, fax and other. Example:
              <code>odit</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>phone_number</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="phone_number" data-endpoint="PUTapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="+1234567890" data-component="body" />
            <br />
            <p>
              The phone number. Max 255 characters. Example:
              <code>+1234567890</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">Delete a contact phone number.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/deleniti/contacts/1/phone-numbers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/deleniti/contacts/1/phone-numbers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/deleniti/contacts/1/phone-numbers/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" data-method="DELETE" data-path="api/vaults/{vault}/contacts/{contact}/phone-numbers/{contactPhoneNumber}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/phone-numbers/{contactPhoneNumber}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="deleniti" data-component="url" />
            <br />
            <p>
              The vault. Example:
              <code>deleniti</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contactPhoneNumber</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="contactPhoneNumber" data-endpoint="DELETEapi-vaults--vault--contacts--contact--phone-numbers--contactPhoneNumber-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact phone number. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-children">Children</h2>
        <h2 id="contacts-GETapi-vaults--vault--contacts--contact--children">List all children.</h2>

        <p></p>

        <p>This API call returns a paginated collection of children.</p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact--children">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/nesciunt/contacts/inventore/children" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/nesciunt/contacts/inventore/children"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/nesciunt/contacts/inventore/children';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact--children">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;child&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;gender&quot;: &quot;boy&quot;,
 &quot;name&quot;: &quot;Michael&quot;,
 &quot;age&quot;: 10,
 &quot;grade_level&quot;: &quot;10th&quot;,
 &quot;school&quot;: &quot;Saint Junior High School&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 5,
 &quot;object&quot;: &quot;child&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;gender&quot;: &quot;girl&quot;,
 &quot;name&quot;: &quot;Dwight&quot;,
 &quot;age&quot;: 10,
 &quot;grade_level&quot;: &quot;10th&quot;,
 &quot;school&quot;: &quot;Saint Junior High School&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/1/children?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/1/children?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/vaults/1/contacts?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/1/children&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact--children" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact--children"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact--children"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact--children" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact--children">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact--children" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}/children" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact--children', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/children</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact--children" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact--children" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact--children" value="nesciunt" data-component="url" />
            <br />
            <p>
              The vault. Example:
              <code>nesciunt</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact--children" value="inventore" data-component="url" />
            <br />
            <p>
              The contact. Example:
              <code>inventore</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;child&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The gender of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>age</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The age of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>grade_level</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The grade level of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>school</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The school of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-GETapi-vaults--vault--contacts--contact--children--child-">Retrieve a child.</h2>

        <p></p>

        <p>The age is approximate, it is calculated based on the age originally defined and the current year. For example, if the age entered is 10 and the age was entered 5 years ago, the age returned will be 15.</p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact--children--child-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/1/contacts/1/children/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/children/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/children/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact--children--child-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;child&quot;,
  &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
  },
  &quot;gender&quot;: &quot;boy&quot;,
  &quot;name&quot;: &quot;John Doe&quot;,
  &quot;age&quot;: 10,
  &quot;grade_level&quot;: &quot;10th&quot;,
  &quot;school&quot;: &quot;Saint Junior High School&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact--children--child-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact--children--child-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact--children--child-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact--children--child-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact--children--child-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact--children--child-" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}/children/{child}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact--children--child-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/children/{child}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact--children--child-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact--children--child-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>child</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="child" data-endpoint="GETapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the child. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;child&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The gender of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>age</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The age of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>grade_level</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The grade level of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>school</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The school of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-POSTapi-vaults--vault--contacts--contact--children">Create a child.</h2>

        <p></p>

        <p>Creates a new child for the given contact. A child has currently two information: gender and name. Only the gender is required, the name is optional. A contact can have multiple children.</p>
        <p>Once created, the child will be returned in the response.</p>

        <span id="example-requests-POSTapi-vaults--vault--contacts--contact--children">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/vaults/1/contacts/1/children" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"gender\": \"boy\",
    \"name\": \"Michael\",
    \"age\": 10,
    \"grade_level\": \"10th\",
    \"school\": \"Saint Junior High School\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/children"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "gender": "boy",
    "name": "Michael",
    "age": 10,
    "grade_level": "10th",
    "school": "Saint Junior High School"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/children';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'gender' =&gt; 'boy',
            'name' =&gt; 'Michael',
            'age' =&gt; 10,
            'grade_level' =&gt; '10th',
            'school' =&gt; 'Saint Junior High School',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-vaults--vault--contacts--contact--children">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;child&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;gender&quot;: &quot;boy&quot;,
 &quot;name&quot;: &quot;Michael&quot;,
 &quot;age&quot;: 10,
 &quot;grade_level&quot;: &quot;10th&quot;,
 &quot;school&quot;: &quot;Saint Junior High School&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-vaults--vault--contacts--contact--children" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-vaults--vault--contacts--contact--children"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-vaults--vault--contacts--contact--children"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-vaults--vault--contacts--contact--children" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-vaults--vault--contacts--contact--children">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-vaults--vault--contacts--contact--children" data-method="POST" data-path="api/vaults/{vault}/contacts/{contact}/children" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-vaults--vault--contacts--contact--children', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/children</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="gender" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="boy" data-component="body" />
            <br />
            <p>
              The gender of the child. Only three values are accepted for this field: 'boy', 'girl', 'other'. Any other value will be rejected. Example:
              <code>boy</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="Michael" data-component="body" />
            <br />
            <p>
              The name of the child. Max 255 characters. Example:
              <code>Michael</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>age</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="number" style="display: none" step="any" name="age" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="10" data-component="body" />
            <br />
            <p>
              The age of the child. Example:
              <code>10</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>grade_level</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="grade_level" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="10th" data-component="body" />
            <br />
            <p>
              The grade level of the child. Example:
              <code>10th</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>school</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="school" data-endpoint="POSTapi-vaults--vault--contacts--contact--children" value="Saint Junior High School" data-component="body" />
            <br />
            <p>
              The school of the child. Example:
              <code>Saint Junior High School</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;child&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The gender of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>age</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The age of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>grade_level</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The grade level of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>school</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The school of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-PUTapi-vaults--vault--contacts--contact--children--child-">Update a child.</h2>

        <p></p>

        <p>Updates an existing child.</p>
        <p>Once updated, the child will be returned in the response.</p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--contact--children--child-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/1/children/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"gender\": \"boy\",
    \"name\": \"Michael\",
    \"age\": 10,
    \"grade_level\": \"10th\",
    \"school\": \"Saint Junior High School\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/children/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "gender": "boy",
    "name": "Michael",
    "age": 10,
    "grade_level": "10th",
    "school": "Saint Junior High School"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/children/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'gender' =&gt; 'boy',
            'name' =&gt; 'Michael',
            'age' =&gt; 10,
            'grade_level' =&gt; '10th',
            'school' =&gt; 'Saint Junior High School',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--contacts--contact--children--child-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;child&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;gender&quot;: &quot;boy&quot;,
 &quot;name&quot;: &quot;Michael&quot;,
 &quot;age&quot;: 10,
 &quot;grade_level&quot;: &quot;10th&quot;,
 &quot;school&quot;: &quot;Saint Junior High School&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--contacts--contact--children--child-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--contact--children--child-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--contact--children--child-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--contact--children--child-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--contact--children--child-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--contact--children--child-" data-method="PUT" data-path="api/vaults/{vault}/contacts/{contact}/children/{child}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--contact--children--child-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/children/{child}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>child</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="child" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the child. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="gender" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="boy" data-component="body" />
            <br />
            <p>
              The gender of the child. Only three values are accepted for this field: 'boy', 'girl', 'other'. Any other value will be rejected. Example:
              <code>boy</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="Michael" data-component="body" />
            <br />
            <p>
              The name of the child. Max 255 characters. Example:
              <code>Michael</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>age</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="number" style="display: none" step="any" name="age" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="10" data-component="body" />
            <br />
            <p>
              The age of the child. Example:
              <code>10</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>grade_level</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="grade_level" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="10th" data-component="body" />
            <br />
            <p>
              The grade level of the child. Example:
              <code>10th</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>school</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="school" data-endpoint="PUTapi-vaults--vault--contacts--contact--children--child-" value="Saint Junior High School" data-component="body" />
            <br />
            <p>
              The school of the child. Example:
              <code>Saint Junior High School</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;child&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>gender</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The gender of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>age</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The age of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>grade_level</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The grade level of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>school</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The school of the child.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-DELETEapi-vaults--vault--contacts--contact--children--child-">Delete a child.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault--contacts--contact--children--child-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/1/contacts/1/children/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/children/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/children/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-vaults--vault--contacts--contact--children--child-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault--contacts--contact--children--child-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault--contacts--contact--children--child-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault--contacts--contact--children--child-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault--contacts--contact--children--child-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault--contacts--contact--children--child-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault--contacts--contact--children--child-" data-method="DELETE" data-path="api/vaults/{vault}/contacts/{contact}/children/{child}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault--contacts--contact--children--child-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/children/{child}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault--contacts--contact--children--child-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault--contacts--contact--children--child-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="DELETEapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>child</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="child" data-endpoint="DELETEapi-vaults--vault--contacts--contact--children--child-" value="1" data-component="url" />
            <br />
            <p>
              The id of the child. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-partners">Partners</h2>
        <h2 id="contacts-GETapi-vaults--vault--contacts--contact--partners">List all partners.</h2>

        <p></p>

        <p>This API call returns a paginated collection of partners.</p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact--partners">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/consequatur/contacts/alias/partners" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/consequatur/contacts/alias/partners"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/consequatur/contacts/alias/partners';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact--partners">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;partner&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;marital_status&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Single&quot;,
 },
 &quot;name&quot;: &quot;Michael&quot;,
 &quot;occupation&quot;: &quot;Software Engineer&quot;,
 &quot;number_of_years_together&quot;: &quot;5&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 5,
 &quot;object&quot;: &quot;partner&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;marital_status&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Single&quot;,
 },
 &quot;name&quot;: &quot;Dwight&quot;,
 &quot;occupation&quot;: &quot;Salesman&quot;,
 &quot;number_of_years_together&quot;: &quot;5&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/1/partners?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/1/partners?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/vaults/1/contacts?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/vaults/1/contacts/1/partners&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact--partners" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact--partners"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact--partners"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact--partners" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact--partners">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact--partners" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}/partners" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact--partners', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/partners</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact--partners" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact--partners" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact--partners" value="consequatur" data-component="url" />
            <br />
            <p>
              The vault. Example:
              <code>consequatur</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact--partners" value="alias" data-component="url" />
            <br />
            <p>
              The contact. Example:
              <code>alias</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;partner&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>marital_status</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The marital status object of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>occupation</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The occupation of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>number_of_years_together</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The number of years the partner has been together.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-GETapi-vaults--vault--contacts--contact--partners--partner-">Retrieve a partner.</h2>

        <p></p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact--partners--partner-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/1/contacts/1/partners/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/partners/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/partners/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact--partners--partner-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;partner&quot;,
  &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
  },
  &quot;marital_status&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Single&quot;,
  },
  &quot;name&quot;: &quot;John Doe&quot;,
  &quot;occupation&quot;: &quot;Software Engineer&quot;,
  &quot;number_of_years_together&quot;: &quot;5&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact--partners--partner-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact--partners--partner-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact--partners--partner-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact--partners--partner-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact--partners--partner-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact--partners--partner-" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}/partners/{partner}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact--partners--partner-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/partners/{partner}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact--partners--partner-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact--partners--partner-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>partner</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="partner" data-endpoint="GETapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the partner. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;partner&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>marital_status</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The marital status object of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>occupation</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The occupation of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>number_of_years_together</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The number of years the partner has been together.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-POSTapi-vaults--vault--contacts--contact--partners">Create a partner.</h2>

        <p></p>

        <p>Creates a new partner for the given contact. A partner has currently three pieces of information: marital status, name and occupation. Only the marital status is required, the name and occupation are optional. A contact can have multiple partners.</p>
        <p>Once created, the partner will be returned in the response.</p>

        <span id="example-requests-POSTapi-vaults--vault--contacts--contact--partners">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/vaults/1/contacts/1/partners" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"marital_status_id\": 1,
    \"name\": \"Michael\",
    \"occupation\": \"Software Engineer\",
    \"number_of_years_together\": \"5\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/partners"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "marital_status_id": 1,
    "name": "Michael",
    "occupation": "Software Engineer",
    "number_of_years_together": "5"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/partners';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'marital_status_id' =&gt; 1,
            'name' =&gt; 'Michael',
            'occupation' =&gt; 'Software Engineer',
            'number_of_years_together' =&gt; '5',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-vaults--vault--contacts--contact--partners">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;partner&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;marital_status&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Single&quot;,
 },
 &quot;name&quot;: &quot;Michael&quot;,
 &quot;occupation&quot;: &quot;Software Engineer&quot;,
 &quot;number_of_years_together&quot;: &quot;5&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-vaults--vault--contacts--contact--partners" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-vaults--vault--contacts--contact--partners"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-vaults--vault--contacts--contact--partners"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-vaults--vault--contacts--contact--partners" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-vaults--vault--contacts--contact--partners">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-vaults--vault--contacts--contact--partners" data-method="POST" data-path="api/vaults/{vault}/contacts/{contact}/partners" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-vaults--vault--contacts--contact--partners', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/partners</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>marital_status_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="marital_status_id" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="1" data-component="body" />
            <br />
            <p>
              The id of the marital status. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="Michael" data-component="body" />
            <br />
            <p>
              The name of the partner. Max 255 characters. Example:
              <code>Michael</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>occupation</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="occupation" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="Software Engineer" data-component="body" />
            <br />
            <p>
              The occupation of the partner. Max 255 characters. Example:
              <code>Software Engineer</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>number_of_years_together</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="number_of_years_together" data-endpoint="POSTapi-vaults--vault--contacts--contact--partners" value="5" data-component="body" />
            <br />
            <p>
              The number of years the partner has been together. Can be a string if needed. Example:
              <code>5</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;partner&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>marital_status</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The marital status object of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>occupation</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The occupation of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>number_of_years_together</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The number of years the partner has been together.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-PUTapi-vaults--vault--contacts--contact--partners--partner-">Update a partner.</h2>

        <p></p>

        <p>Updates an existing partner.</p>
        <p>Once updated, the partner will be returned in the response.</p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--contact--partners--partner-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/1/partners/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"marital_status_id\": 1,
    \"name\": \"Michael\",
    \"occupation\": \"Software Engineer\",
    \"number_of_years_together\": \"5\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/partners/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "marital_status_id": 1,
    "name": "Michael",
    "occupation": "Software Engineer",
    "number_of_years_together": "5"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/partners/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'marital_status_id' =&gt; 1,
            'name' =&gt; 'Michael',
            'occupation' =&gt; 'Software Engineer',
            'number_of_years_together' =&gt; '5',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--contacts--contact--partners--partner-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;partner&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;marital_status&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Single&quot;,
 },
 &quot;name&quot;: &quot;Michael&quot;,
 &quot;occupation&quot;: &quot;Software Engineer&quot;,
 &quot;number_of_years_together&quot;: &quot;5&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--contacts--contact--partners--partner-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--contact--partners--partner-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--contact--partners--partner-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--contact--partners--partner-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--contact--partners--partner-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--contact--partners--partner-" data-method="PUT" data-path="api/vaults/{vault}/contacts/{contact}/partners/{partner}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--contact--partners--partner-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/partners/{partner}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>partner</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="partner" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the partner. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>marital_status_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="marital_status_id" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="body" />
            <br />
            <p>
              The id of the marital status. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="Michael" data-component="body" />
            <br />
            <p>
              The name of the partner. Max 255 characters. Example:
              <code>Michael</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>occupation</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="occupation" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="Software Engineer" data-component="body" />
            <br />
            <p>
              The occupation of the partner. Max 255 characters. Example:
              <code>Software Engineer</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>number_of_years_together</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="number_of_years_together" data-endpoint="PUTapi-vaults--vault--contacts--contact--partners--partner-" value="5" data-component="body" />
            <br />
            <p>
              The number of years the partner has been together. Can be a string if needed. Example:
              <code>5</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;partner&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object who represents the parent.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>marital_status</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The marital status object of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>occupation</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The occupation of the partner.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>number_of_years_together</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The number of years the partner has been together.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="contacts-DELETEapi-vaults--vault--contacts--contact--partners--partner-">Delete a partner.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault--contacts--contact--partners--partner-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/1/contacts/1/partners/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/partners/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/partners/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-vaults--vault--contacts--contact--partners--partner-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault--contacts--contact--partners--partner-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault--contacts--contact--partners--partner-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault--contacts--contact--partners--partner-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault--contacts--contact--partners--partner-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault--contacts--contact--partners--partner-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault--contacts--contact--partners--partner-" data-method="DELETE" data-path="api/vaults/{vault}/contacts/{contact}/partners/{partner}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault--contacts--contact--partners--partner-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/partners/{partner}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault--contacts--contact--partners--partner-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault--contacts--contact--partners--partner-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="DELETEapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>partner</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="partner" data-endpoint="DELETEapi-vaults--vault--contacts--contact--partners--partner-" value="1" data-component="url" />
            <br />
            <p>
              The id of the partner. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="ethnicities">Ethnicities</h1>

        <p>Ethnicity refers to a person's identification with a group based on common ancestry, language, cultural heritage, or national origin.</p>
        <p>Ethnicities are defined at the account level and shared by all users in the account. If you delete an ethnicity it will be removed from all the contacts that are using it.</p>

        <h2 id="ethnicities-GETapi-ethnicities">List all ethnicities.</h2>

        <p></p>

        <p>This API call returns a paginated collection of ethnicities that contains 15 items per page.</p>

        <span id="example-requests-GETapi-ethnicities">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/ethnicities" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/ethnicities"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/ethnicities';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-ethnicities">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;ethnicity&quot;,
 &quot;label&quot;: &quot;Hispanic&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 2,
 &quot;object&quot;: &quot;ethnicity&quot;,
 &quot;label&quot;: &quot;Asian&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/ethnicities?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/ethnicities?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/ethnicities?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/ethnicities&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 2,
   &quot;total&quot;: 2
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-ethnicities" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-ethnicities"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-ethnicities"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-ethnicities" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-ethnicities">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-ethnicities" data-method="GET" data-path="api/ethnicities" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-ethnicities', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ethnicities</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-ethnicities" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-ethnicities" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;ethnicity&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the ethnicity.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="ethnicities-GETapi-ethnicities--ethnicity-">Retrieve an ethnicity.</h2>

        <p></p>

        <span id="example-requests-GETapi-ethnicities--ethnicity-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/ethnicities/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/ethnicities/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/ethnicities/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-ethnicities--ethnicity-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;object&quot;: &quot;ethnicity&quot;,
    &quot;label&quot;: &quot;Hispanic&quot;,
    &quot;created_at&quot;: 1514764800,
    &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
          <blockquote>
            <p>Example response (401):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;There is no ethnicity with this id in your account.&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-ethnicities--ethnicity-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-ethnicities--ethnicity-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-ethnicities--ethnicity-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-ethnicities--ethnicity-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-ethnicities--ethnicity-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-ethnicities--ethnicity-" data-method="GET" data-path="api/ethnicities/{ethnicity}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-ethnicities--ethnicity-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ethnicities/{ethnicity}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-ethnicities--ethnicity-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-ethnicities--ethnicity-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>ethnicity</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="ethnicity" data-endpoint="GETapi-ethnicities--ethnicity-" value="1" data-component="url" />
            <br />
            <p>
              The id of the ethnicity. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;ethnicity&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The name of the ethnicity.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="ethnicities-POSTapi-ethnicities">Create an ethnicity.</h2>

        <p></p>

        <span id="example-requests-POSTapi-ethnicities">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/ethnicities" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Hispanic\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/ethnicities"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Hispanic"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/ethnicities';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Hispanic',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-ethnicities">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;ethnicity&quot;,
 &quot;label&quot;: &quot;Hispanic&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-ethnicities" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-ethnicities"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-ethnicities"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-ethnicities" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-ethnicities">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-ethnicities" data-method="POST" data-path="api/ethnicities" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-ethnicities', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/ethnicities</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-ethnicities" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-ethnicities" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>label</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="label" data-endpoint="POSTapi-ethnicities" value="Hispanic" data-component="body" />
            <br />
            <p>
              The name of the ethnicity. Max 255 characters. Example:
              <code>Hispanic</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;ethnicity&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The label of the ethnicity.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="ethnicities-PUTapi-ethnicities--ethnicity-">Update an ethnicity.</h2>

        <p></p>

        <span id="example-requests-PUTapi-ethnicities--ethnicity-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/ethnicities/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Latino\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/ethnicities/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Latino"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/ethnicities/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Latino',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-ethnicities--ethnicity-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;ethnicity&quot;,
 &quot;label&quot;: &quot;Latino&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-ethnicities--ethnicity-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-ethnicities--ethnicity-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-ethnicities--ethnicity-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-ethnicities--ethnicity-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-ethnicities--ethnicity-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-ethnicities--ethnicity-" data-method="PUT" data-path="api/ethnicities/{ethnicity}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-ethnicities--ethnicity-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/ethnicities/{ethnicity}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-ethnicities--ethnicity-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-ethnicities--ethnicity-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>ethnicity</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="ethnicity" data-endpoint="PUTapi-ethnicities--ethnicity-" value="1" data-component="url" />
            <br />
            <p>
              The id of the ethnicity. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>label</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="label" data-endpoint="PUTapi-ethnicities--ethnicity-" value="Latino" data-component="body" />
            <br />
            <p>
              The label of the ethnicity. Max 255 characters. Example:
              <code>Latino</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;ethnicity&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the ethnicity.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="ethnicities-DELETEapi-ethnicities--ethnicity-">Delete an ethnicity.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-ethnicities--ethnicity-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/ethnicities/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/ethnicities/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/ethnicities/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-ethnicities--ethnicity-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-ethnicities--ethnicity-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-ethnicities--ethnicity-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-ethnicities--ethnicity-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-ethnicities--ethnicity-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-ethnicities--ethnicity-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-ethnicities--ethnicity-" data-method="DELETE" data-path="api/ethnicities/{ethnicity}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-ethnicities--ethnicity-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/ethnicities/{ethnicity}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-ethnicities--ethnicity-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-ethnicities--ethnicity-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>ethnicity</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="ethnicity" data-endpoint="DELETEapi-ethnicities--ethnicity-" value="1" data-component="url" />
            <br />
            <p>
              The id of the ethnicity. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="genders">Genders</h1>

        <p>Gender for a human refers to the roles, behaviors, activities, expectations, and societal norms that cultures and societies consider appropriate for men, women, and other gender identities.</p>
        <p>Genders are defined at the account level and shared by all users in the account. If you delete a gender it will be removed from all the contacts that are using it.</p>
        <p>Genders are ordered by their position. The first gender has a position of 1.</p>

        <h2 id="genders-GETapi-genders">List all genders.</h2>

        <p></p>

        <p>This API call returns a paginated collection of genders that contains 15 items per page.</p>

        <span id="example-requests-GETapi-genders">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/genders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/genders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/genders';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-genders">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;gender&quot;,
 &quot;label&quot;: &quot;Male&quot;,
 &quot;position&quot;: 1,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 2,
 &quot;object&quot;: &quot;gender&quot;,
 &quot;label&quot;: &quot;Female&quot;,
 &quot;position&quot;: 2,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/genders?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/genders?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/genders?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/genders&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-genders" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-genders"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-genders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-genders" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-genders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-genders" data-method="GET" data-path="api/genders" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-genders', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/genders</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-genders" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-genders" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;gender&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the gender.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="genders-GETapi-genders--gender-">Retrieve a gender.</h2>

        <p></p>

        <span id="example-requests-GETapi-genders--gender-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/genders/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/genders/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/genders/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-genders--gender-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;object&quot;: &quot;gender&quot;,
    &quot;label&quot;: &quot;Male&quot;,
    &quot;position&quot;: 1,
    &quot;created_at&quot;: 1514764800,
    &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
          <blockquote>
            <p>Example response (401):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;There is no gender with this id in your account.&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-genders--gender-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-genders--gender-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-genders--gender-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-genders--gender-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-genders--gender-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-genders--gender-" data-method="GET" data-path="api/genders/{gender}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-genders--gender-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/genders/{gender}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-genders--gender-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-genders--gender-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="gender" data-endpoint="GETapi-genders--gender-" value="1" data-component="url" />
            <br />
            <p>
              The id of the gender. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;gender&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The name of the gender.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>position</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The position of the gender.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="genders-POSTapi-genders">Create a gender.</h2>

        <p></p>

        <span id="example-requests-POSTapi-genders">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/genders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Male\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/genders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Male"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/genders';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Male',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-genders">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;gender&quot;,
 &quot;label&quot;: &quot;Male&quot;,
 &quot;position&quot;: 1,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-genders" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-genders"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-genders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-genders" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-genders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-genders" data-method="POST" data-path="api/genders" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-genders', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/genders</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-genders" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-genders" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>label</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="label" data-endpoint="POSTapi-genders" value="Male" data-component="body" />
            <br />
            <p>
              The label of the gender. Max 255 characters. Example:
              <code>Male</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;gender&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the gender.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>position</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The position of the gender.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="genders-PUTapi-genders--gender-">Update a gender.</h2>

        <p></p>

        <span id="example-requests-PUTapi-genders--gender-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/genders/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Male\",
    \"position\": 1
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/genders/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Male",
    "position": 1
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/genders/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Male',
            'position' =&gt; 1,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-genders--gender-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;gender&quot;,
 &quot;label&quot;: &quot;Male&quot;,
 &quot;position&quot;: 1,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-genders--gender-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-genders--gender-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-genders--gender-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-genders--gender-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-genders--gender-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-genders--gender-" data-method="PUT" data-path="api/genders/{gender}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-genders--gender-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/genders/{gender}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-genders--gender-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-genders--gender-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="gender" data-endpoint="PUTapi-genders--gender-" value="1" data-component="url" />
            <br />
            <p>
              The id of the gender. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>label</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="label" data-endpoint="PUTapi-genders--gender-" value="Male" data-component="body" />
            <br />
            <p>
              The label of the gender. Max 255 characters. Example:
              <code>Male</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>position</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="position" data-endpoint="PUTapi-genders--gender-" value="1" data-component="body" />
            <br />
            <p>
              The position of the gender. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;gender&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the gender.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>position</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The position of the gender.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="genders-DELETEapi-genders--gender-">Delete a gender.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-genders--gender-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/genders/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/genders/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/genders/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-genders--gender-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-genders--gender-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-genders--gender-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-genders--gender-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-genders--gender-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-genders--gender-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-genders--gender-" data-method="DELETE" data-path="api/genders/{gender}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-genders--gender-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/genders/{gender}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-genders--gender-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-genders--gender-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="gender" data-endpoint="DELETEapi-genders--gender-" value="1" data-component="url" />
            <br />
            <p>
              The id of the gender. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="notes">Notes</h1>

        <p>Notes are a way to add additional information to a contact. You can have as many notes as you want for a contact. We support markdown formatting, so it's up to the client to render it properly, as the body might contain markdown in the response.</p>

        <h2 id="notes-GETapi-vaults--vault--contacts--contact--notes">List all notes.</h2>

        <p></p>

        <p>This will list all the notes.</p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact--notes">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/1/contacts/1/notes" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/notes"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/notes';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact--notes">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">[{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;note&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;body&quot;: &quot;This is a note.&quot;,
 &quot;created_at&quot;: 1718982400,
}, {
 &quot;id&quot;: 5,
 &quot;object&quot;: &quot;note&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;body&quot;: &quot;This is another note.&quot;,
 &quot;created_at&quot;: 1718982400,
 &quot;updated_at&quot;: 1718982400,
}]</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact--notes" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact--notes"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact--notes"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact--notes" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact--notes">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact--notes" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}/notes" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact--notes', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/notes</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact--notes" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact--notes" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact--notes" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact--notes" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;note&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>body</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The body of the note.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="notes-GETapi-vaults--vault--contacts--contact--notes--note-">Retrieve a note.</h2>

        <p></p>

        <span id="example-requests-GETapi-vaults--vault--contacts--contact--notes--note-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/1/contacts/1/notes/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/notes/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/notes/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault--contacts--contact--notes--note-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;id&quot;: 1,
  &quot;object&quot;: &quot;note&quot;,
  &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
  },
  &quot;body&quot;: &quot;This is a note.&quot;,
  &quot;created_at&quot;: 1514764800,
  &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault--contacts--contact--notes--note-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault--contacts--contact--notes--note-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault--contacts--contact--notes--note-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault--contacts--contact--notes--note-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault--contacts--contact--notes--note-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault--contacts--contact--notes--note-" data-method="GET" data-path="api/vaults/{vault}/contacts/{contact}/notes/{note}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault--contacts--contact--notes--note-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/notes/{note}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault--contacts--contact--notes--note-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault--contacts--contact--notes--note-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="GETapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>note</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="note" data-endpoint="GETapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the note. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;note&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>body</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The body of the note.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="notes-POSTapi-vaults--vault--contacts--contact--notes">Create a note.</h2>

        <p></p>

        <span id="example-requests-POSTapi-vaults--vault--contacts--contact--notes">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/vaults/1/contacts/1/notes" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"body\": \"This is a note.\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/notes"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "body": "This is a note."
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/notes';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'body' =&gt; 'This is a note.',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-vaults--vault--contacts--contact--notes">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;note&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;body&quot;: &quot;This is a note.&quot;,
 &quot;created_at&quot;: 1718982400,
 &quot;updated_at&quot;: 1718982400,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-vaults--vault--contacts--contact--notes" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-vaults--vault--contacts--contact--notes"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-vaults--vault--contacts--contact--notes"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-vaults--vault--contacts--contact--notes" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-vaults--vault--contacts--contact--notes">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-vaults--vault--contacts--contact--notes" data-method="POST" data-path="api/vaults/{vault}/contacts/{contact}/notes" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-vaults--vault--contacts--contact--notes', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/notes</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-vaults--vault--contacts--contact--notes" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-vaults--vault--contacts--contact--notes" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="POSTapi-vaults--vault--contacts--contact--notes" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="POSTapi-vaults--vault--contacts--contact--notes" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>body</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="body" data-endpoint="POSTapi-vaults--vault--contacts--contact--notes" value="This is a note." data-component="body" />
            <br />
            <p>
              The body of the note. Example:
              <code>This is a note.</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;note&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>body</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The body of the note.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="notes-PUTapi-vaults--vault--contacts--contact--notes--note-">Update a note.</h2>

        <p></p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--contact--notes--note-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/1/notes/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"body\": \"This is a note.\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/notes/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "body": "This is a note."
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/notes/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'body' =&gt; 'This is a note.',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault--contacts--contact--notes--note-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;note&quot;,
 &quot;contact&quot;: {
     &quot;id&quot;: 1,
     &quot;name&quot;: &quot;Dwight Schrute&quot;,
 },
 &quot;body&quot;: &quot;This is a note.&quot;,
 &quot;created_at&quot;: 1718982400,
 &quot;updated_at&quot;: 1718982400,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault--contacts--contact--notes--note-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--contact--notes--note-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--contact--notes--note-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--contact--notes--note-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--contact--notes--note-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--contact--notes--note-" data-method="PUT" data-path="api/vaults/{vault}/contacts/{contact}/notes/{note}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--contact--notes--note-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/notes/{note}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--contact--notes--note-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--contact--notes--note-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>note</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="note" data-endpoint="PUTapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the note. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>body</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="body" data-endpoint="PUTapi-vaults--vault--contacts--contact--notes--note-" value="This is a note." data-component="body" />
            <br />
            <p>
              The body of the note. Example:
              <code>This is a note.</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;note&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>contact</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The contact object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>body</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The body of the note.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="notes-DELETEapi-vaults--vault--contacts--contact--notes--note-">Delete a note.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault--contacts--contact--notes--note-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/1/contacts/1/notes/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/1/notes/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1/contacts/1/notes/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-vaults--vault--contacts--contact--notes--note-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault--contacts--contact--notes--note-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault--contacts--contact--notes--note-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault--contacts--contact--notes--note-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault--contacts--contact--notes--note-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault--contacts--contact--notes--note-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault--contacts--contact--notes--note-" data-method="DELETE" data-path="api/vaults/{vault}/contacts/{contact}/notes/{note}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault--contacts--contact--notes--note-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}/contacts/{contact}/notes/{note}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault--contacts--contact--notes--note-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault--contacts--contact--notes--note-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="DELETEapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>note</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="note" data-endpoint="DELETEapi-vaults--vault--contacts--contact--notes--note-" value="1" data-component="url" />
            <br />
            <p>
              The id of the note. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="profile">Profile</h1>

        <p>You can modify your profile information here.</p>

        <h2 id="profile-GETapi-me">Get the information about the logged user.</h2>

        <p></p>

        <p>This endpoint gets the information about the logged user.</p>

        <span id="example-requests-GETapi-me">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/me"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/me';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-me">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;first_name&quot;: &quot;Jessica&quot;,
    &quot;last_name&quot;: &quot;Jones&quot;,
    &quot;email&quot;: &quot;jessica.jones@gmail.com&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-me" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-me"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-me" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-me" data-method="GET" data-path="api/me" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-me', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/me</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-me" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-me" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
        </form>

        <h2 id="profile-PUTapi-me">Update your profile.</h2>

        <p></p>

        <p>This lets you update the profile of the logged user. Only the logged user can update their profile. If you change your email, you will need to verify it again.</p>
        <p>Please note that your password can not be changed through the API at the moment.</p>

        <span id="example-requests-PUTapi-me">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"first_name\": \"Jessica\",
    \"last_name\": \"Jones\",
    \"email\": \"jessica.jones@gmail.com\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/me"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "Jessica",
    "last_name": "Jones",
    "email": "jessica.jones@gmail.com"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/me';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'first_name' =&gt; 'Jessica',
            'last_name' =&gt; 'Jones',
            'email' =&gt; 'jessica.jones@gmail.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-me">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;first_name&quot;: &quot;Jessica&quot;,
    &quot;last_name&quot;: &quot;Jones&quot;,
    &quot;email&quot;: &quot;jessica.jones@gmail.com&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-me" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-me"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-me" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-me" data-method="PUT" data-path="api/me" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-me', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/me</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-me" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-me" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>first_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="first_name" data-endpoint="PUTapi-me" value="Jessica" data-component="body" />
            <br />
            <p>
              The first name of the user. Max 255 characters. Example:
              <code>Jessica</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>last_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="last_name" data-endpoint="PUTapi-me" value="Jones" data-component="body" />
            <br />
            <p>
              The last name of the user. Max 255 characters. Example:
              <code>Jones</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>email</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="email" data-endpoint="PUTapi-me" value="jessica.jones@gmail.com" data-component="body" />
            <br />
            <p>
              The email of the user. Max 255 characters. Example:
              <code>jessica.jones@gmail.com</code>
            </p>
          </div>
        </form>

        <h1 id="templates">Templates</h1>

        <p>Templates define the structure of a journal entry. As of this writing, the content of a template is defined as a YAML file. The YAML file is interpreted by the application to render the journal entry the day the template is used.</p>

        <h2 id="templates-GETapi-templates">List all templates.</h2>

        <p></p>

        <p>This API call returns a paginated collection of templates that contains 15 items per page.</p>

        <span id="example-requests-GETapi-templates">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/templates" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/templates"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/templates';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-templates">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;template&quot;,
 &quot;name&quot;: &quot;Work day&quot;,
 &quot;content&quot;: &quot;&lt;a YAML file&gt;&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 2,
 &quot;object&quot;: &quot;template&quot;,
 &quot;name&quot;: &quot;Work day&quot;,
 &quot;content&quot;: &quot;&lt;a YAML file&gt;&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/templates?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/templates?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/templates?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/templates&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-templates" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-templates"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-templates"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-templates" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-templates">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-templates" data-method="GET" data-path="api/templates" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-templates', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/templates</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-templates" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-templates" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;template&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the template.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>content</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The content of the template which is a YAML file.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="templates-GETapi-templates--template-">Retrieve a template.</h2>

        <p></p>

        <span id="example-requests-GETapi-templates--template-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/templates/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/templates/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/templates/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-templates--template-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;object&quot;: &quot;template&quot;,
    &quot;name&quot;: &quot;Work day&quot;,
    &quot;content&quot;: &quot;&lt;a YAML file&gt;&quot;,
    &quot;created_at&quot;: 1514764800,
    &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
          <blockquote>
            <p>Example response (401):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;There is no template with this id in your account.&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-templates--template-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-templates--template-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-templates--template-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-templates--template-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-templates--template-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-templates--template-" data-method="GET" data-path="api/templates/{template}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-templates--template-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/templates/{template}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-templates--template-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-templates--template-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>template</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="template" data-endpoint="GETapi-templates--template-" value="1" data-component="url" />
            <br />
            <p>
              The id of the template. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;template&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The name of the template.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>content</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The content of the template which is a YAML file.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="templates-POSTapi-templates">Create a template.</h2>

        <p></p>

        <span id="example-requests-POSTapi-templates">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/templates" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Work day\",
    \"content\": \"any valid YAML file\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/templates"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Work day",
    "content": "any valid YAML file"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/templates';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Work day',
            'content' =&gt; 'any valid YAML file',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-templates">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;template&quot;,
 &quot;name&quot;: &quot;Work day&quot;,
 &quot;content&quot;: &quot;&lt;a YAML file&gt;&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-templates" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-templates"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-templates"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-templates" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-templates">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-templates" data-method="POST" data-path="api/templates" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-templates', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/templates</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-templates" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-templates" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-templates" value="Work day" data-component="body" />
            <br />
            <p>
              The name of the template. Max 255 characters. Example:
              <code>Work day</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>content</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="content" data-endpoint="POSTapi-templates" value="any valid YAML file" data-component="body" />
            <br />
            <p>
              The content of the template which is a YAML file. Example:
              <code>any valid YAML file</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;template&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the template.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>content</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The content of the template which is a YAML file.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="templates-PUTapi-templates--template-">Update a template.</h2>

        <p></p>

        <span id="example-requests-PUTapi-templates--template-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/templates/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Work day\",
    \"content\": \"any valid YAML file\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/templates/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Work day",
    "content": "any valid YAML file"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/templates/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Work day',
            'content' =&gt; 'any valid YAML file',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-templates--template-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;template&quot;,
 &quot;name&quot;: &quot;Work day&quot;,
 &quot;content&quot;: &quot;&lt;a YAML file&gt;&quot;,
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-templates--template-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-templates--template-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-templates--template-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-templates--template-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-templates--template-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-templates--template-" data-method="PUT" data-path="api/templates/{template}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-templates--template-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/templates/{template}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-templates--template-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-templates--template-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>template</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="template" data-endpoint="PUTapi-templates--template-" value="1" data-component="url" />
            <br />
            <p>
              The id of the template. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-templates--template-" value="Work day" data-component="body" />
            <br />
            <p>
              The name of the template. Max 255 characters. Example:
              <code>Work day</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>content</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="content" data-endpoint="PUTapi-templates--template-" value="any valid YAML file" data-component="body" />
            <br />
            <p>
              The content of the template which is a YAML file. Example:
              <code>any valid YAML file</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The object type. Always &quot;template&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the template.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>content</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The content of the template which is a YAML file.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="templates-DELETEapi-templates--template-">Delete a template.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-templates--template-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/templates/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/templates/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/templates/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-templates--template-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-templates--template-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-templates--template-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-templates--template-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-templates--template-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-templates--template-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-templates--template-" data-method="DELETE" data-path="api/templates/{template}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-templates--template-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/templates/{template}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-templates--template-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-templates--template-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>template</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="template" data-endpoint="DELETEapi-templates--template-" value="1" data-component="url" />
            <br />
            <p>
              The id of the template. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="vaults">Vaults</h1>

        <p>Vaults are used to store contacts and all the related data. You can create as many vaults as you need.</p>

        <h2 id="vaults-GETapi-vaults">List all vaults.</h2>

        <p></p>

        <p>This will list all the vaults, sorted alphabetically, that the user has access to. This API call returns a paginated collection of genders that contains 15 items per page. This will not return the vaults that the user does not have access to.</p>

        <span id="example-requests-GETapi-vaults">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;vault&quot;,
 &quot;name&quot;: &quot;New vault&quot;,
 &quot;description&quot;: &quot;This is a new vault&quot;
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800
}, {
 &quot;id&quot;: 5,
 &quot;object&quot;: &quot;vault&quot;,
 &quot;name&quot;: &quot;Old vault&quot;,
 &quot;description&quot;: &quot;This is an old vault&quot;
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/genders?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/genders?page=1&quot;,
  &quot;prev&quot;: null,
  &quot;next&quot;: null
 },
 &quot;meta&quot;: {
   &quot;current_page&quot;: 1,
   &quot;from&quot;: 1,
   &quot;last_page&quot;: 1,
   &quot;links&quot;: [
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
       &quot;active&quot;: false
     },
     {
       &quot;url&quot;: &quot;http://peopleos.test/api/genders?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/genders&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults" data-method="GET" data-path="api/vaults" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>description</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The description of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="vaults-POSTapi-vaults">Create a vault.</h2>

        <p></p>

        <p>A vault is a place where you can store contacts and all the related data. When you create a vault, a contact representing you will be created automatically. You will not be able to delete this contact–only another manager of the vault can do so.</p>

        <span id="example-requests-POSTapi-vaults">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "http://peopleos.test/api/vaults" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"New vault\",
    \"description\": \"This is a new vault\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "New vault",
    "description": "This is a new vault"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'New vault',
            'description' =&gt; 'This is a new vault',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-vaults">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;vault&quot;,
 &quot;name&quot;: &quot;New vault&quot;,
 &quot;description&quot;: &quot;This is a new vault&quot;
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-vaults" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-vaults"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-vaults"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-vaults" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-vaults">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-vaults" data-method="POST" data-path="api/vaults" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-vaults', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/vaults</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-vaults" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-vaults" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-vaults" value="New vault" data-component="body" />
            <br />
            <p>
              The name of the vault. Max 255 characters. Example:
              <code>New vault</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>description</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="description" data-endpoint="POSTapi-vaults" value="This is a new vault" data-component="body" />
            <br />
            <p>
              The description of the vault. Max 255 characters. Example:
              <code>This is a new vault</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>description</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The description of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="vaults-GETapi-vaults--vault-">Retrieve a vault.</h2>

        <p></p>

        <span id="example-requests-GETapi-vaults--vault-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-GETapi-vaults--vault-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;vault&quot;,
 &quot;name&quot;: &quot;New vault&quot;,
 &quot;description&quot;: &quot;This is a new vault&quot;
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-vaults--vault-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-vaults--vault-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-vaults--vault-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-vaults--vault-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-vaults--vault-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-vaults--vault-" data-method="GET" data-path="api/vaults/{vault}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-vaults--vault-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/vaults/{vault}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-vaults--vault-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-vaults--vault-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>description</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The description of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="vaults-PUTapi-vaults--vault-">Update a vault.</h2>

        <p></p>

        <span id="example-requests-PUTapi-vaults--vault-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"New vault\",
    \"description\": \"This is a new vault\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "New vault",
    "description": "This is a new vault"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'New vault',
            'description' =&gt; 'This is a new vault',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-vaults--vault-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;id&quot;: 4,
 &quot;object&quot;: &quot;vault&quot;,
 &quot;name&quot;: &quot;New vault&quot;,
 &quot;description&quot;: &quot;This is a new vault&quot;
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-vaults--vault-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault-" data-method="PUT" data-path="api/vaults/{vault}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-vaults--vault-" value="New vault" data-component="body" />
            <br />
            <p>
              The name of the vault. Max 255 characters. Example:
              <code>New vault</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>description</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="description" data-endpoint="PUTapi-vaults--vault-" value="This is a new vault" data-component="body" />
            <br />
            <p>
              The description of the vault. Max 255 characters. Example:
              <code>This is a new vault</code>
            </p>
          </div>
        </form>

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Unique identifier for the object.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>label</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>description</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The description of the vault.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was created. Represented as a Unix timestamp.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>updated_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The date the object was last updated. Represented as a Unix timestamp.</p>
        </div>
        <h2 id="vaults-DELETEapi-vaults--vault-">Delete a vault.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://peopleos.test/api/vaults/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-DELETEapi-vaults--vault-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault-" data-method="DELETE" data-path="api/vaults/{vault}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>vault</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
        </form>
      </div>
      <div class="dark-box">
        <div class="lang-selector">
          <button type="button" class="lang-button" data-language-name="bash">bash</button>
          <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
          <button type="button" class="lang-button" data-language-name="php">php</button>
        </div>
      </div>
    </div>
  </body>
</html>
