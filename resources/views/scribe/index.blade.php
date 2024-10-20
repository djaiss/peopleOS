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
            <li class="tocify-item level-2" data-unique="contacts-GETapi-vaults--vault--contacts">
              <a href="#contacts-GETapi-vaults--vault--contacts">List all contacts.</a>
            </li>
            <li class="tocify-item level-2" data-unique="contacts-POSTapi-vaults--vault--contacts">
              <a href="#contacts-POSTapi-vaults--vault--contacts">Create a contact.</a>
            </li>
            <li class="tocify-item level-2" data-unique="contacts-PUTapi-vaults--vault--contacts--slug--job">
              <a href="#contacts-PUTapi-vaults--vault--contacts--slug--job">Update a contact's job information.</a>
            </li>
            <li class="tocify-item level-2" data-unique="contacts-PUTapi-vaults--vault--contacts--slug--background">
              <a href="#contacts-PUTapi-vaults--vault--contacts--slug--background">Update a contact's background information.</a>
            </li>
            <li class="tocify-item level-2" data-unique="contacts-DELETEapi-vaults--vault--contacts--slug-">
              <a href="#contacts-DELETEapi-vaults--vault--contacts--slug-">Delete a contact.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-endpoints" class="tocify-header">
          <li class="tocify-item level-1" data-unique="endpoints">
            <a href="#endpoints">Endpoints</a>
          </li>
          <ul id="tocify-subheader-endpoints" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="endpoints-GETapi-me">
              <a href="#endpoints-GETapi-me">Get the information about the logged user.</a>
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
        <li>Last updated: October 21, 2024</li>
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

        <h2 id="contacts-GETapi-vaults--vault--contacts">List all contacts.</h2>

        <p></p>

        <p>This API call returns a paginated collection of contacts that contains 15 items per page.</p>

        <span id="example-requests-GETapi-vaults--vault--contacts">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "http://peopleos.test/api/vaults/qui/contacts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/qui/contacts"
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
$url = 'http://peopleos.test/api/vaults/qui/contacts';
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
 &quot;name&quot;: &quot;Michael Scott&quot;,
 &quot;first_name&quot;: &quot;Michael&quot;,
 &quot;last_name&quot;: &quot;Scott&quot;,
 &quot;middle_name&quot;: &quot;Gary&quot;,
 &quot;nickname&quot;: &quot;Mike&quot;,
 &quot;maiden_name&quot;: &quot;Johnson&quot;,
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
 &quot;name&quot;: &quot;Dwight Schrute&quot;,
 &quot;first_name&quot;: &quot;Dwight&quot;,
 &quot;last_name&quot;: &quot;Schrute&quot;,
 &quot;middle_name&quot;: &quot;Kurt&quot;,
 &quot;nickname&quot;: &quot;Dwight&quot;,
 &quot;maiden_name&quot;: &quot;Schrute&quot;,
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
            <input type="text" style="display: none" name="vault" data-endpoint="GETapi-vaults--vault--contacts" value="qui" data-component="url" />
            <br />
            <p>
              The vault. Example:
              <code>qui</code>
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

        <p>Creates a new contact in the vault. For this to happen, the user must have the permission to edit the vault.</p>
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
    \"first_name\": \"Michael\",
    \"last_name\": \"Scott\",
    \"middle_name\": \"Gary\",
    \"nickname\": \"Mike\",
    \"maiden_name\": \"Johnson\",
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
    "first_name": "Michael",
    "last_name": "Scott",
    "middle_name": "Gary",
    "nickname": "Mike",
    "maiden_name": "Johnson",
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
            'first_name' =&gt; 'Michael',
            'last_name' =&gt; 'Scott',
            'middle_name' =&gt; 'Gary',
            'nickname' =&gt; 'Mike',
            'maiden_name' =&gt; 'Johnson',
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
 &quot;name&quot;: &quot;Michael Scott&quot;,
 &quot;first_name&quot;: &quot;Michael&quot;,
 &quot;last_name&quot;: &quot;Scott&quot;,
 &quot;middle_name&quot;: &quot;Gary&quot;,
 &quot;nickname&quot;: &quot;Mike&quot;,
 &quot;maiden_name&quot;: &quot;Johnson&quot;,
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
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="gender_id" data-endpoint="POSTapi-vaults--vault--contacts" value="1" data-component="body" />
            <br />
            <p>
              The gender object associated with the contact. This object must be a valid Gender object. Example:
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
            &nbsp; &nbsp;
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
              The maiden name of the contact. Max 255 characters. Example:
              <code>Johnson</code>
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
        <h2 id="contacts-PUTapi-vaults--vault--contacts--slug--job">Update a contact&#039;s job information.</h2>

        <p></p>

        <p>A contact can have one job, linked to a company. You don't need to manually create the company, it will be created if it doesn't exist. This check is done based on the company name.</p>
        <p>If you want a more granular control over the company itself, you can use the dedicated company endpoints.</p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--slug--job">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/praesentium/job" \
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
    "http://peopleos.test/api/vaults/1/contacts/praesentium/job"
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
$url = 'http://peopleos.test/api/vaults/1/contacts/praesentium/job';
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

        <span id="example-responses-PUTapi-vaults--vault--contacts--slug--job">
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
        <span id="execution-results-PUTapi-vaults--vault--contacts--slug--job" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--slug--job"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--slug--job"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--slug--job" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--slug--job">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--slug--job" data-method="PUT" data-path="api/vaults/{vault}/contacts/{slug}/job" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--slug--job', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{slug}/job</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--slug--job" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--slug--job" value="application/json" data-component="header" />
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
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--slug--job" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>slug</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="slug" data-endpoint="PUTapi-vaults--vault--contacts--slug--job" value="praesentium" data-component="url" />
            <br />
            <p>
              The slug of the contact. Example:
              <code>praesentium</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--slug--job" value="1" data-component="url" />
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
            <input type="text" style="display: none" name="job_title" data-endpoint="PUTapi-vaults--vault--contacts--slug--job" value="CEO" data-component="body" />
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
            <input type="text" style="display: none" name="company_name" data-endpoint="PUTapi-vaults--vault--contacts--slug--job" value="Dunder Mifflin" data-component="body" />
            <br />
            <p>
              The name of the company. Max 255 characters. Example:
              <code>Dunder Mifflin</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-PUTapi-vaults--vault--contacts--slug--background">Update a contact&#039;s background information.</h2>

        <p></p>

        <span id="example-requests-PUTapi-vaults--vault--contacts--slug--background">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "http://peopleos.test/api/vaults/1/contacts/quasi/background" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"information\": \"CEO\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/quasi/background"
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
$url = 'http://peopleos.test/api/vaults/1/contacts/quasi/background';
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

        <span id="example-responses-PUTapi-vaults--vault--contacts--slug--background">
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
        <span id="execution-results-PUTapi-vaults--vault--contacts--slug--background" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-vaults--vault--contacts--slug--background"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-vaults--vault--contacts--slug--background"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-vaults--vault--contacts--slug--background" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-vaults--vault--contacts--slug--background">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-vaults--vault--contacts--slug--background" data-method="PUT" data-path="api/vaults/{vault}/contacts/{slug}/background" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-vaults--vault--contacts--slug--background', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/vaults/{vault}/contacts/{slug}/background</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-vaults--vault--contacts--slug--background" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-vaults--vault--contacts--slug--background" value="application/json" data-component="header" />
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
            <input type="text" style="display: none" name="vault" data-endpoint="PUTapi-vaults--vault--contacts--slug--background" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>slug</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="slug" data-endpoint="PUTapi-vaults--vault--contacts--slug--background" value="quasi" data-component="url" />
            <br />
            <p>
              The slug of the contact. Example:
              <code>quasi</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="PUTapi-vaults--vault--contacts--slug--background" value="1" data-component="url" />
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
            <input type="text" style="display: none" name="information" data-endpoint="PUTapi-vaults--vault--contacts--slug--background" value="CEO" data-component="body" />
            <br />
            <p>
              The background information about the contact. Can be anything, really. Max 255 characters. Example:
              <code>CEO</code>
            </p>
          </div>
        </form>

        <h2 id="contacts-DELETEapi-vaults--vault--contacts--slug-">Delete a contact.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-vaults--vault--contacts--slug-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "http://peopleos.test/api/vaults/1/contacts/eligendi" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "http://peopleos.test/api/vaults/1/contacts/eligendi"
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
$url = 'http://peopleos.test/api/vaults/1/contacts/eligendi';
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

        <span id="example-responses-DELETEapi-vaults--vault--contacts--slug-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-vaults--vault--contacts--slug-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-vaults--vault--contacts--slug-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-vaults--vault--contacts--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-vaults--vault--contacts--slug-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-vaults--vault--contacts--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-vaults--vault--contacts--slug-" data-method="DELETE" data-path="api/vaults/{vault}/contacts/{slug}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-vaults--vault--contacts--slug-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/vaults/{vault}/contacts/{slug}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-vaults--vault--contacts--slug-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-vaults--vault--contacts--slug-" value="application/json" data-component="header" />
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
            <input type="text" style="display: none" name="vault" data-endpoint="DELETEapi-vaults--vault--contacts--slug-" value="1" data-component="url" />
            <br />
            <p>
              The id of the vault. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>slug</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="slug" data-endpoint="DELETEapi-vaults--vault--contacts--slug-" value="eligendi" data-component="url" />
            <br />
            <p>
              The slug of the contact. Example:
              <code>eligendi</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>contact</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="contact" data-endpoint="DELETEapi-vaults--vault--contacts--slug-" value="1" data-component="url" />
            <br />
            <p>
              The id of the contact. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="endpoints">Endpoints</h1>

        <h2 id="endpoints-GETapi-me">Get the information about the logged user.</h2>

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

        <h1 id="genders">Genders</h1>

        <p>Gender for a human refers to the roles, behaviors, activities, expectations, and societal norms that cultures and societies consider appropriate for men, women, and other gender identities.</p>
        <p>Genders are defined at the account level and shared by all users in the account. If you delete a gender it will be removed from all the contacts that are using it.</p>

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
 &quot;created_at&quot;: 1514764800,
 &quot;updated_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 2,
 &quot;object&quot;: &quot;gender&quot;,
 &quot;label&quot;: &quot;Female&quot;,
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
    \"label\": \"Male\"
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
    "label": "Male"
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

        <h1 id="vaults">Vaults</h1>

        <p>Vaults are used to store contacts and all the related data. You can create as many vaults as you need. To access a vault, you need to have the permissions to do so. There are three permissions: view, edit, and manage.</p>

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

        <p>A vault is a place where you can store contacts and all the related data. When you create a vault, your user will be associated with it with the Manage permission. Also, a contact representing you will be created automatically. You will not be able to delete this contact–only another manager of the vault can do so.</p>

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
