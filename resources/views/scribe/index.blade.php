<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Laravel Documentation</title>

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

    <script src="{{ asset('/vendor/scribe/js/theme-default-4.39.0.js') }}"></script>
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
        <ul id="tocify-header-administration" class="tocify-header">
          <li class="tocify-item level-1" data-unique="administration">
            <a href="#administration">Administration</a>
          </li>
          <ul id="tocify-subheader-administration" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="administration-GETapi-me">
              <a href="#administration-GETapi-me">Get the information about the logged user.</a>
            </li>
            <li class="tocify-item level-2" data-unique="administration-PUTapi-me">
              <a href="#administration-PUTapi-me">Update your profile.</a>
            </li>
            <li class="tocify-item level-2" data-unique="administration-manage-offices">
              <a href="#administration-manage-offices">Manage offices</a>
            </li>
            <ul id="tocify-subheader-administration-manage-offices" class="tocify-subheader">
              <li class="tocify-item level-3" data-unique="administration-POSTapi-administration-offices">
                <a href="#administration-POSTapi-administration-offices">Create an office.</a>
              </li>
              <li class="tocify-item level-3" data-unique="administration-PUTapi-administration-offices--id-">
                <a href="#administration-PUTapi-administration-offices--id-">Update an office.</a>
              </li>
              <li class="tocify-item level-3" data-unique="administration-DELETEapi-administration-offices--id-">
                <a href="#administration-DELETEapi-administration-offices--id-">Delete an office.</a>
              </li>
              <li class="tocify-item level-3" data-unique="administration-GETapi-administration-offices">
                <a href="#administration-GETapi-administration-offices">List offices.</a>
              </li>
            </ul>
            <li class="tocify-item level-2" data-unique="administration-manage-users">
              <a href="#administration-manage-users">Manage users</a>
            </li>
            <ul id="tocify-subheader-administration-manage-users" class="tocify-subheader">
              <li class="tocify-item level-3" data-unique="administration-POSTapi-administration-users">
                <a href="#administration-POSTapi-administration-users">Invite a user.</a>
              </li>
              <li class="tocify-item level-3" data-unique="administration-PUTapi-administration-users--user_id--invite">
                <a href="#administration-PUTapi-administration-users--user_id--invite">Send a new invitation to a user.</a>
              </li>
            </ul>
          </ul>
        </ul>
        <ul id="tocify-header-genders" class="tocify-header">
          <li class="tocify-item level-1" data-unique="genders">
            <a href="#genders">Genders</a>
          </li>
          <ul id="tocify-subheader-genders" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="genders-GETapi-administration-genders">
              <a href="#genders-GETapi-administration-genders">List all genders.</a>
            </li>
            <li class="tocify-item level-2" data-unique="genders-POSTapi-administration-genders">
              <a href="#genders-POSTapi-administration-genders">Create a gender.</a>
            </li>
            <li class="tocify-item level-2" data-unique="genders-PUTapi-administration-genders--id-">
              <a href="#genders-PUTapi-administration-genders--id-">Update a gender.</a>
            </li>
            <li class="tocify-item level-2" data-unique="genders-DELETEapi-administration-genders--id-">
              <a href="#genders-DELETEapi-administration-genders--id-">Delete a gender.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-marital-statuses" class="tocify-header">
          <li class="tocify-item level-1" data-unique="marital-statuses">
            <a href="#marital-statuses">Marital statuses</a>
          </li>
          <ul id="tocify-subheader-marital-statuses" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="marital-statuses-GETapi-administration-marital-statuses">
              <a href="#marital-statuses-GETapi-administration-marital-statuses">List all marital statuses.</a>
            </li>
            <li class="tocify-item level-2" data-unique="marital-statuses-POSTapi-administration-marital-statuses">
              <a href="#marital-statuses-POSTapi-administration-marital-statuses">Create a marital status.</a>
            </li>
            <li class="tocify-item level-2" data-unique="marital-statuses-PUTapi-administration-marital-statuses--maritalStatus_id-">
              <a href="#marital-statuses-PUTapi-administration-marital-statuses--maritalStatus_id-">Update a marital status.</a>
            </li>
            <li class="tocify-item level-2" data-unique="marital-statuses-DELETEapi-administration-marital-statuses--maritalStatus_id-">
              <a href="#marital-statuses-DELETEapi-administration-marital-statuses--maritalStatus_id-">Delete a marital status.</a>
            </li>
          </ul>
        </ul>
        <ul id="tocify-header-teams" class="tocify-header">
          <li class="tocify-item level-1" data-unique="teams">
            <a href="#teams">Teams</a>
          </li>
          <ul id="tocify-subheader-teams" class="tocify-subheader">
            <li class="tocify-item level-2" data-unique="teams-POSTapi-teams">
              <a href="#teams-POSTapi-teams">Create a team.</a>
            </li>
            <li class="tocify-item level-2" data-unique="teams-PUTapi-teams--id-">
              <a href="#teams-PUTapi-teams--id-">Update a team.</a>
            </li>
            <li class="tocify-item level-2" data-unique="teams-DELETEapi-teams--id-">
              <a href="#teams-DELETEapi-teams--id-">Delete a team.</a>
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
        <li>Last updated: January 16, 2025</li>
      </ul>
    </div>

    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
        <h1 id="introduction">Introduction</h1>
        <aside>
          <strong>Base URL</strong>
          :
          <code>https://peopleos.test</code>
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

        <h1 id="administration">Administration</h1>

        <p>You can modify your profile information here.</p>

        <h2 id="administration-GETapi-me">Get the information about the logged user.</h2>

        <p></p>

        <p>This endpoint gets the information about the logged user.</p>

        <span id="example-requests-GETapi-me">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "https://peopleos.test/api/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/me"
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
$url = 'https://peopleos.test/api/me';
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
    &quot;first_name&quot;: &quot;Ross&quot;,
    &quot;last_name&quot;: &quot;Geller&quot;,
    &quot;nickname&quot;: &quot;Ross&quot;,
    &quot;email&quot;: &quot;ross.geller@friends.com&quot;,
    &quot;born_at&quot;: &quot;1985-03-15&quot;
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

        <h3>Response</h3>
        <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The ID of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>first_name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The first name of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>last_name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The last name of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nickname</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The nickname of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>email</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The email of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>born_at</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The birth date of the user. Format: YYYY-MM-DD</p>
        </div>
        <h2 id="administration-PUTapi-me">Update your profile.</h2>

        <p></p>

        <p>This lets you update your profile. Only you can change these fields.</p>
        <p>If you change your email, the system will send a new verification email to verify the new email address.</p>
        <p>Please note that your password can not be changed through the API at the moment.</p>

        <span id="example-requests-PUTapi-me">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "https://peopleos.test/api/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"first_name\": \"Dwight\",
    \"last_name\": \"Schrute\",
    \"email\": \"dwight.schrute@dundermifflin.com\",
    \"nickname\": \"Dwight\",
    \"born_at\": \"1985-03-15\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/me"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "Dwight",
    "last_name": "Schrute",
    "email": "dwight.schrute@dundermifflin.com",
    "nickname": "Dwight",
    "born_at": "1985-03-15"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/me';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'first_name' =&gt; 'Dwight',
            'last_name' =&gt; 'Schrute',
            'email' =&gt; 'dwight.schrute@dundermifflin.com',
            'nickname' =&gt; 'Dwight',
            'born_at' =&gt; '1985-03-15',
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
    &quot;first_name&quot;: &quot;Ross&quot;,
    &quot;last_name&quot;: &quot;Geller&quot;,
    &quot;nickname&quot;: &quot;Ross&quot;,
    &quot;email&quot;: &quot;ross.geller@friends.com&quot;,
    &quot;born_at&quot;: &quot;1985-03-15&quot;
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
            <input type="text" style="display: none" name="first_name" data-endpoint="PUTapi-me" value="Dwight" data-component="body" />
            <br />
            <p>
              The first name of the user. Max 255 characters. Example:
              <code>Dwight</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>last_name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="last_name" data-endpoint="PUTapi-me" value="Schrute" data-component="body" />
            <br />
            <p>
              The last name of the user. Max 255 characters. Example:
              <code>Schrute</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>email</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="email" data-endpoint="PUTapi-me" value="dwight.schrute@dundermifflin.com" data-component="body" />
            <br />
            <p>
              The email of the user. Max 255 characters. Example:
              <code>dwight.schrute@dundermifflin.com</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>nickname</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="nickname" data-endpoint="PUTapi-me" value="Dwight" data-component="body" />
            <br />
            <p>
              The nickname of the user. Max 255 characters. Example:
              <code>Dwight</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>born_at</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp;
            <i>optional</i>
            &nbsp;
            <input type="text" style="display: none" name="born_at" data-endpoint="PUTapi-me" value="1985-03-15" data-component="body" />
            <br />
            <p>
              The birth date of the user. Format: YYYY-MM-DD. Example:
              <code>1985-03-15</code>
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
          <p>The ID of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>first_name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The first name of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>last_name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The last name of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>email</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The email of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>nickname</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The nickname of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>born_at</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The birth date of the user. Format: YYYY-MM-DD</p>
        </div>
        <h2 id="administration-manage-offices">Manage offices</h2>
        <h2 id="administration-POSTapi-administration-offices">Create an office.</h2>

        <p></p>

        <p>An office is a physical location where employees work. It can be a branch, a department, or any other location where employees work.</p>
        <p>Only administrators can create an office.</p>

        <span id="example-requests-POSTapi-administration-offices">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "https://peopleos.test/api/administration/offices" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Scranton Branch\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/offices"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Scranton Branch"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/offices';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Scranton Branch',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-administration-offices">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;office&quot;,
    &quot;account_id&quot;: 1,
    &quot;name&quot;: &quot;Scranton Branch&quot;,
    &quot;created_at&quot;: &quot;1679090539&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-administration-offices" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-administration-offices"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-administration-offices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-administration-offices" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-administration-offices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-administration-offices" data-method="POST" data-path="api/administration/offices" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-administration-offices', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/administration/offices</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-administration-offices" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-administration-offices" value="application/json" data-component="header" />
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
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-administration-offices" value="Scranton Branch" data-component="body" />
            <br />
            <p>
              The name of the office. Max 255 characters. Example:
              <code>Scranton Branch</code>
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
          <p>The ID of the office.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;office&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>account_id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The ID of the account.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The name of the office.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>Time at which the object was created. Measured in seconds since the Unix epoch.</p>
        </div>
        <h2 id="administration-PUTapi-administration-offices--id-">Update an office.</h2>

        <p></p>

        <p>Only administrators can update an office.</p>

        <span id="example-requests-PUTapi-administration-offices--id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "https://peopleos.test/api/administration/offices/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Scranton Branch\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/offices/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Scranton Branch"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/offices/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Scranton Branch',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-administration-offices--id-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;office&quot;,
    &quot;account_id&quot;: 1,
    &quot;name&quot;: &quot;Scranton Branch&quot;,
    &quot;created_at&quot;: &quot;1679090539&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-administration-offices--id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-administration-offices--id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-administration-offices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-administration-offices--id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-administration-offices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-administration-offices--id-" data-method="PUT" data-path="api/administration/offices/{id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-administration-offices--id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/administration/offices/{id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-administration-offices--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-administration-offices--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="id" data-endpoint="PUTapi-administration-offices--id-" value="1" data-component="url" />
            <br />
            <p>
              The ID of the office. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>office</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="office" data-endpoint="PUTapi-administration-offices--id-" value="4" data-component="url" />
            <br />
            <p>
              The ID of the office. Example:
              <code>4</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-administration-offices--id-" value="Scranton Branch" data-component="body" />
            <br />
            <p>
              The name of the office. Max 255 characters. Example:
              <code>Scranton Branch</code>
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
          <p>The ID of the office.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;office&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>account_id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The ID of the account.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The name of the office.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>Time at which the object was created. Measured in seconds since the Unix epoch.</p>
        </div>
        <h2 id="administration-DELETEapi-administration-offices--id-">Delete an office.</h2>

        <p></p>

        <p>Only administrators can delete an office.</p>

        <span id="example-requests-DELETEapi-administration-offices--id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "https://peopleos.test/api/administration/offices/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/offices/1"
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
$url = 'https://peopleos.test/api/administration/offices/1';
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

        <span id="example-responses-DELETEapi-administration-offices--id-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-administration-offices--id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-administration-offices--id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-administration-offices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-administration-offices--id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-administration-offices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-administration-offices--id-" data-method="DELETE" data-path="api/administration/offices/{id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-administration-offices--id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/administration/offices/{id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-administration-offices--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-administration-offices--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="id" data-endpoint="DELETEapi-administration-offices--id-" value="1" data-component="url" />
            <br />
            <p>
              The ID of the office. Example:
              <code>1</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>office</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="office" data-endpoint="DELETEapi-administration-offices--id-" value="4" data-component="url" />
            <br />
            <p>
              The ID of the office. Example:
              <code>4</code>
            </p>
          </div>
        </form>

        <h2 id="administration-GETapi-administration-offices">List offices.</h2>

        <p></p>

        <p>This API call returns a paginated collection of offices that contains 15 items per page. This list is ordered by the creation date. The offices in this call are for the administration of the account.</p>
        <p>Only administrators can list the offices from an administration point of view.</p>

        <span id="example-requests-GETapi-administration-offices">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "https://peopleos.test/api/administration/offices" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/offices"
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
$url = 'https://peopleos.test/api/administration/offices';
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

        <span id="example-responses-GETapi-administration-offices">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;office&quot;,
 &quot;account_id&quot;: 1,
 &quot;name&quot;: &quot;New York Branch&quot;,
 &quot;created_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 2,
 &quot;object&quot;: &quot;office&quot;,
 &quot;account_id&quot;: 1,
 &quot;name&quot;: &quot;Scranton Branch&quot;,
 &quot;created_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://organizationos.test/api/administration/offices?page=1&quot;,
  &quot;last&quot;: &quot;http://organizationos.test/api/administration/offices?page=1&quot;,
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
       &quot;url&quot;: &quot;http://organizationos.test/api/administration/offices?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://organizationos.test/api/administration/offices&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-administration-offices" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-administration-offices"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-administration-offices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-administration-offices" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-administration-offices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-administration-offices" data-method="GET" data-path="api/administration/offices" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-administration-offices', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/administration/offices</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-administration-offices" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-administration-offices" value="application/json" data-component="header" />
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
          <p>The object type. Always &quot;office&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>account_id</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The ID of the account.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the office.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Time at which the object was created. Measured in seconds since the Unix epoch.</p>
        </div>
        <h2 id="administration-manage-users">Manage users</h2>
        <h2 id="administration-POSTapi-administration-users">Invite a user.</h2>

        <p></p>

        <p>Invites a user to the account. Only administrators and HR representatives can invite users.</p>
        <p>By default, the user will have the Member permission.</p>
        <p>The invitation will be valid for 3 days. After 3 days, the user will need to request a new invitation.</p>

        <span id="example-requests-POSTapi-administration-users">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "https://peopleos.test/api/administration/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"dwight.schrute@dundermifflin.com\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "dwight.schrute@dundermifflin.com"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/users';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'email' =&gt; 'dwight.schrute@dundermifflin.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-administration-users">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;user&quot;,
    &quot;email&quot;: &quot;ross.geller@friends.com&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-administration-users" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-administration-users"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-administration-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-administration-users" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-administration-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-administration-users" data-method="POST" data-path="api/administration/users" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-administration-users', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/administration/users</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-administration-users" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-administration-users" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>email</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="email" data-endpoint="POSTapi-administration-users" value="dwight.schrute@dundermifflin.com" data-component="body" />
            <br />
            <p>
              The email of the user. Max 255 characters. Example:
              <code>dwight.schrute@dundermifflin.com</code>
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
          <p>The ID of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;user&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>email</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The email of the user.</p>
        </div>
        <h2 id="administration-PUTapi-administration-users--user_id--invite">Send a new invitation to a user.</h2>

        <p></p>

        <p>Sends a new invitation to a user who has not yet accepted the invitation. Only administrators and HR representatives can send a new invitation.</p>
        <p>The invitation will be valid for 3 days. After 3 days, the user will need to request a new invitation.</p>

        <span id="example-requests-PUTapi-administration-users--user_id--invite">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "https://peopleos.test/api/administration/users/1/invite" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/users/1/invite"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers,
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/users/1/invite';
$response = $client-&gt;put(
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

        <span id="example-responses-PUTapi-administration-users--user_id--invite">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;user&quot;,
    &quot;email&quot;: &quot;ross.geller@friends.com&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-administration-users--user_id--invite" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-administration-users--user_id--invite"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-administration-users--user_id--invite"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-administration-users--user_id--invite" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-administration-users--user_id--invite">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-administration-users--user_id--invite" data-method="PUT" data-path="api/administration/users/{user_id}/invite" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-administration-users--user_id--invite', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/administration/users/{user_id}/invite</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-administration-users--user_id--invite" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-administration-users--user_id--invite" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>user_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="user_id" data-endpoint="PUTapi-administration-users--user_id--invite" value="1" data-component="url" />
            <br />
            <p>
              The ID of the user. Example:
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
          <p>The ID of the user.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;user&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>email</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The email of the user.</p>
        </div>
        <h1 id="genders">Genders</h1>

        <h2 id="genders-GETapi-administration-genders">List all genders.</h2>

        <p></p>

        <p>Returns a list of genders in the account, ordered by position.</p>

        <span id="example-requests-GETapi-administration-genders">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "https://peopleos.test/api/administration/genders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/genders"
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
$url = 'https://peopleos.test/api/administration/genders';
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

        <span id="example-responses-GETapi-administration-genders">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;gender&quot;,
 &quot;name&quot;: &quot;Male&quot;,
 &quot;position&quot;: 1,
 &quot;created_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 2,
 &quot;object&quot;: &quot;gender&quot;,
 &quot;name&quot;: &quot;Female&quot;,
 &quot;position&quot;: 2,
 &quot;created_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/administration/genders?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/administration/genders?page=1&quot;,
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
       &quot;url&quot;: &quot;http://peopleos.test/api/administration/genders?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/administration/genders&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-administration-genders" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-administration-genders"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-administration-genders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-administration-genders" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-administration-genders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-administration-genders" data-method="GET" data-path="api/administration/genders" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-administration-genders', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/administration/genders</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-administration-genders" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-administration-genders" value="application/json" data-component="header" />
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
          <p>The ID of the gender</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;gender&quot;</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the gender</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>position</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The position of the gender in the list</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Time at which the object was created. Measured in seconds since the Unix epoch</p>
        </div>
        <h2 id="genders-POSTapi-administration-genders">Create a gender.</h2>

        <p></p>

        <p>A gender categorizes the gender identity of a person. Genders are ordered by position. When you create a new gender, it will be added to the end of the list by default - ie after the max gender position. A person can have one gender, or not gender at all.</p>

        <span id="example-requests-POSTapi-administration-genders">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "https://peopleos.test/api/administration/genders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Male\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/genders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Male"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/genders';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Male',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-administration-genders">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;object&quot;: &quot;gender&quot;,
        &quot;name&quot;: &quot;Male&quot;,
        &quot;position&quot;: 1,
        &quot;created_at&quot;: &quot;1679090539&quot;
    }
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-administration-genders" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-administration-genders"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-administration-genders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-administration-genders" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-administration-genders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-administration-genders" data-method="POST" data-path="api/administration/genders" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-administration-genders', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/administration/genders</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-administration-genders" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-administration-genders" value="application/json" data-component="header" />
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
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-administration-genders" value="Male" data-component="body" />
            <br />
            <p>
              The name of the gender. Max 255 characters. Example:
              <code>Male</code>
            </p>
          </div>
        </form>

        <h2 id="genders-PUTapi-administration-genders--id-">Update a gender.</h2>

        <p></p>

        <span id="example-requests-PUTapi-administration-genders--id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "https://peopleos.test/api/administration/genders/12" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Female\",
    \"position\": 2
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/genders/12"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Female",
    "position": 2
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/genders/12';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Female',
            'position' =&gt; 2,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-administration-genders--id-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;object&quot;: &quot;gender&quot;,
        &quot;name&quot;: &quot;Female&quot;,
        &quot;position&quot;: 2,
        &quot;created_at&quot;: &quot;1679090539&quot;
    }
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-administration-genders--id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-administration-genders--id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-administration-genders--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-administration-genders--id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-administration-genders--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-administration-genders--id-" data-method="PUT" data-path="api/administration/genders/{id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-administration-genders--id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/administration/genders/{id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-administration-genders--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-administration-genders--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="id" data-endpoint="PUTapi-administration-genders--id-" value="12" data-component="url" />
            <br />
            <p>
              The ID of the gender. Example:
              <code>12</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="gender" data-endpoint="PUTapi-administration-genders--id-" value="1" data-component="url" />
            <br />
            <p>
              The ID of the gender. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-administration-genders--id-" value="Female" data-component="body" />
            <br />
            <p>
              The name of the gender. Max 255 characters. Example:
              <code>Female</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>position</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="position" data-endpoint="PUTapi-administration-genders--id-" value="2" data-component="body" />
            <br />
            <p>
              The position of the gender in the list. Example:
              <code>2</code>
            </p>
          </div>
        </form>

        <h2 id="genders-DELETEapi-administration-genders--id-">Delete a gender.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-administration-genders--id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "https://peopleos.test/api/administration/genders/12" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/genders/12"
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
$url = 'https://peopleos.test/api/administration/genders/12';
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

        <span id="example-responses-DELETEapi-administration-genders--id-">
          <blockquote>
            <p>Example response (204):</p>
          </blockquote>
          <pre>
<code>Empty response</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-administration-genders--id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-administration-genders--id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-administration-genders--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-administration-genders--id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-administration-genders--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-administration-genders--id-" data-method="DELETE" data-path="api/administration/genders/{id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-administration-genders--id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/administration/genders/{id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-administration-genders--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-administration-genders--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="id" data-endpoint="DELETEapi-administration-genders--id-" value="12" data-component="url" />
            <br />
            <p>
              The ID of the gender. Example:
              <code>12</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>gender</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="gender" data-endpoint="DELETEapi-administration-genders--id-" value="1" data-component="url" />
            <br />
            <p>
              The ID of the gender. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="marital-statuses">Marital statuses</h1>

        <h2 id="marital-statuses-GETapi-administration-marital-statuses">List all marital statuses.</h2>

        <p></p>

        <p>Returns a list of marital statuses in the account, ordered by position.</p>

        <span id="example-requests-GETapi-administration-marital-statuses">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request GET \
    --get "https://peopleos.test/api/administration/marital-statuses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/marital-statuses"
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
$url = 'https://peopleos.test/api/administration/marital-statuses';
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

        <span id="example-responses-GETapi-administration-marital-statuses">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{&quot;data&quot;: [{
 &quot;id&quot;: 1,
 &quot;object&quot;: &quot;marital_status&quot;,
 &quot;name&quot;: &quot;Married&quot;,
 &quot;position&quot;: 1,
 &quot;created_at&quot;: 1514764800,
}, {
 &quot;id&quot;: 2,
 &quot;object&quot;: &quot;marital_status&quot;,
 &quot;name&quot;: &quot;Divorced&quot;,
 &quot;position&quot;: 2,
 &quot;created_at&quot;: 1514764800,
}],
&quot;links&quot;: {
  &quot;first&quot;: &quot;http://peopleos.test/api/administration/marital-statuses?page=1&quot;,
  &quot;last&quot;: &quot;http://peopleos.test/api/administration/marital-statuses?page=1&quot;,
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
       &quot;url&quot;: &quot;http://peopleos.test/api/administration/marital-statuses?page=1&quot;,
       &quot;label&quot;: &quot;1&quot;,
       &quot;active&quot;: true
     },
     {
       &quot;url&quot;: null,
       &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
       &quot;active&quot;: false
     }
   ],
   &quot;path&quot;: &quot;http://peopleos.test/api/administration/marital-statuses&quot;,
   &quot;per_page&quot;: 15,
   &quot;to&quot;: 1,
   &quot;total&quot;: 1
 }</code>
 </pre>
        </span>
        <span id="execution-results-GETapi-administration-marital-statuses" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-GETapi-administration-marital-statuses"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-GETapi-administration-marital-statuses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-GETapi-administration-marital-statuses" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-GETapi-administration-marital-statuses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-GETapi-administration-marital-statuses" data-method="GET" data-path="api/administration/marital-statuses" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('GETapi-administration-marital-statuses', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/administration/marital-statuses</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="GETapi-administration-marital-statuses" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="GETapi-administration-marital-statuses" value="application/json" data-component="header" />
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
          <p>The ID of the marital status</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;marital_status&quot;</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The name of the marital status</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>position</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>The position of the marital status in the list</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp; &nbsp; &nbsp;
          <br />
          <p>Time at which the object was created. Measured in seconds since the Unix epoch</p>
        </div>
        <h2 id="marital-statuses-POSTapi-administration-marital-statuses">Create a marital status.</h2>

        <p></p>

        <p>A marital status categorizes the marital status of a person. Marital statuses are ordered by position. When you create a new marital status, it will be added to the end of the list by default - ie after the max marital status position. A person can have one marital status, or not marital status at all.</p>

        <span id="example-requests-POSTapi-administration-marital-statuses">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "https://peopleos.test/api/administration/marital-statuses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Married\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/marital-statuses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Married"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/marital-statuses';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Married',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-administration-marital-statuses">
          <blockquote>
            <p>Example response (201):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;object&quot;: &quot;marital_status&quot;,
        &quot;name&quot;: &quot;Married&quot;,
        &quot;position&quot;: 1,
        &quot;created_at&quot;: &quot;1679090539&quot;
    }
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-administration-marital-statuses" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-administration-marital-statuses"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-administration-marital-statuses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-administration-marital-statuses" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-administration-marital-statuses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-administration-marital-statuses" data-method="POST" data-path="api/administration/marital-statuses" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-administration-marital-statuses', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/administration/marital-statuses</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-administration-marital-statuses" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-administration-marital-statuses" value="application/json" data-component="header" />
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
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-administration-marital-statuses" value="Married" data-component="body" />
            <br />
            <p>
              The name of the marital status. Max 255 characters. Example:
              <code>Married</code>
            </p>
          </div>
        </form>

        <h2 id="marital-statuses-PUTapi-administration-marital-statuses--maritalStatus_id-">Update a marital status.</h2>

        <p></p>

        <span id="example-requests-PUTapi-administration-marital-statuses--maritalStatus_id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "https://peopleos.test/api/administration/marital-statuses/18" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Married\",
    \"position\": 2
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/marital-statuses/18"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Married",
    "position": 2
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/administration/marital-statuses/18';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Married',
            'position' =&gt; 2,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-administration-marital-statuses--maritalStatus_id-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;object&quot;: &quot;marital_status&quot;,
        &quot;name&quot;: &quot;Divorced&quot;,
        &quot;position&quot;: 2,
        &quot;created_at&quot;: &quot;1679090539&quot;
    }
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-administration-marital-statuses--maritalStatus_id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-administration-marital-statuses--maritalStatus_id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-administration-marital-statuses--maritalStatus_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-administration-marital-statuses--maritalStatus_id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-administration-marital-statuses--maritalStatus_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-administration-marital-statuses--maritalStatus_id-" data-method="PUT" data-path="api/administration/marital-statuses/{maritalStatus_id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-administration-marital-statuses--maritalStatus_id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/administration/marital-statuses/{maritalStatus_id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-administration-marital-statuses--maritalStatus_id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-administration-marital-statuses--maritalStatus_id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>maritalStatus_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="maritalStatus_id" data-endpoint="PUTapi-administration-marital-statuses--maritalStatus_id-" value="18" data-component="url" />
            <br />
            <p>
              The ID of the maritalStatus. Example:
              <code>18</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>marital_status</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="marital_status" data-endpoint="PUTapi-administration-marital-statuses--maritalStatus_id-" value="1" data-component="url" />
            <br />
            <p>
              The ID of the marital status. Example:
              <code>1</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-administration-marital-statuses--maritalStatus_id-" value="Married" data-component="body" />
            <br />
            <p>
              The name of the marital status. Max 255 characters. Example:
              <code>Married</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>position</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="position" data-endpoint="PUTapi-administration-marital-statuses--maritalStatus_id-" value="2" data-component="body" />
            <br />
            <p>
              The position of the marital status in the list. Example:
              <code>2</code>
            </p>
          </div>
        </form>

        <h2 id="marital-statuses-DELETEapi-administration-marital-statuses--maritalStatus_id-">Delete a marital status.</h2>

        <p></p>

        <span id="example-requests-DELETEapi-administration-marital-statuses--maritalStatus_id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "https://peopleos.test/api/administration/marital-statuses/16" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/administration/marital-statuses/16"
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
$url = 'https://peopleos.test/api/administration/marital-statuses/16';
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

        <span id="example-responses-DELETEapi-administration-marital-statuses--maritalStatus_id-">
          <blockquote>
            <p>Example response (204):</p>
          </blockquote>
          <pre>
<code>Empty response</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-administration-marital-statuses--maritalStatus_id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-administration-marital-statuses--maritalStatus_id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-administration-marital-statuses--maritalStatus_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-administration-marital-statuses--maritalStatus_id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-administration-marital-statuses--maritalStatus_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-administration-marital-statuses--maritalStatus_id-" data-method="DELETE" data-path="api/administration/marital-statuses/{maritalStatus_id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-administration-marital-statuses--maritalStatus_id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/administration/marital-statuses/{maritalStatus_id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-administration-marital-statuses--maritalStatus_id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-administration-marital-statuses--maritalStatus_id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>maritalStatus_id</code></b>
            &nbsp;&nbsp;
            <small>integer</small>
            &nbsp; &nbsp;
            <input type="number" style="display: none" step="any" name="maritalStatus_id" data-endpoint="DELETEapi-administration-marital-statuses--maritalStatus_id-" value="16" data-component="url" />
            <br />
            <p>
              The ID of the maritalStatus. Example:
              <code>16</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>marital_status</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="marital_status" data-endpoint="DELETEapi-administration-marital-statuses--maritalStatus_id-" value="1" data-component="url" />
            <br />
            <p>
              The ID of the marital status. Example:
              <code>1</code>
            </p>
          </div>
        </form>

        <h1 id="teams">Teams</h1>

        <h2 id="teams-POSTapi-teams">Create a team.</h2>

        <p></p>

        <p>A team is a group of users. This should not be used to manage the hierarchy of the company, as hierarchy is handled automatically by the system.</p>

        <span id="example-requests-POSTapi-teams">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request POST \
    "https://peopleos.test/api/teams" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Web developers\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/teams"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Web developers"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/teams';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Web developers',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-POSTapi-teams">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;team&quot;,
    &quot;account_id&quot;: 1,
    &quot;name&quot;: &quot;Web developers&quot;,
    &quot;created_at&quot;: &quot;1679090539&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-POSTapi-teams" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-POSTapi-teams"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-POSTapi-teams"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-POSTapi-teams" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-POSTapi-teams">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-POSTapi-teams" data-method="POST" data-path="api/teams" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="POSTapi-teams" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="POSTapi-teams" value="application/json" data-component="header" />
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
            <input type="text" style="display: none" name="name" data-endpoint="POSTapi-teams" value="Web developers" data-component="body" />
            <br />
            <p>
              The name of the team. Max 255 characters. Example:
              <code>Web developers</code>
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
          <p>The ID of the team.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;team&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>account_id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The ID of the account.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The name of the team.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>Time at which the object was created. Measured in seconds since the Unix epoch.</p>
        </div>
        <h2 id="teams-PUTapi-teams--id-">Update a team.</h2>

        <p></p>

        <p>A team can be updated by any user who is part of the team.</p>

        <span id="example-requests-PUTapi-teams--id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request PUT \
    "https://peopleos.test/api/teams/id" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Web developers\"
}"
</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/teams/id"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Web developers"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
          </div>

          <div class="php-example">
            <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'https://peopleos.test/api/teams/id';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Web developers',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
          </div>
        </span>

        <span id="example-responses-PUTapi-teams--id-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 4,
    &quot;object&quot;: &quot;team&quot;,
    &quot;account_id&quot;: 1,
    &quot;name&quot;: &quot;Web developers&quot;,
    &quot;created_at&quot;: &quot;1679090539&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-PUTapi-teams--id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-PUTapi-teams--id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-PUTapi-teams--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-PUTapi-teams--id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-PUTapi-teams--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-PUTapi-teams--id-" data-method="PUT" data-path="api/teams/{id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('PUTapi-teams--id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/teams/{id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="PUTapi-teams--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="PUTapi-teams--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>id</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="id" data-endpoint="PUTapi-teams--id-" value="id" data-component="url" />
            <br />
            <p>
              The ID of the team. Example:
              <code>id</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>name</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="name" data-endpoint="PUTapi-teams--id-" value="Web developers" data-component="body" />
            <br />
            <p>
              The name of the team. Max 255 characters. Example:
              <code>Web developers</code>
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
          <p>The ID of the team.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>object</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The type of the object. Always &quot;team&quot;.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>account_id</code></b>
          &nbsp;&nbsp;
          <small>integer</small>
          &nbsp; &nbsp;
          <br />
          <p>The ID of the account.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>name</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>The name of the team.</p>
        </div>
        <div style="padding-left: 28px; clear: unset">
          <b style="line-height: 2"><code>created_at</code></b>
          &nbsp;&nbsp;
          <small>string</small>
          &nbsp; &nbsp;
          <br />
          <p>Time at which the object was created. Measured in seconds since the Unix epoch.</p>
        </div>
        <h2 id="teams-DELETEapi-teams--id-">Delete a team.</h2>

        <p></p>

        <p>A team can be deleted by any user who is part of the team.</p>

        <span id="example-requests-DELETEapi-teams--id-">
          <blockquote>Example request:</blockquote>

          <div class="bash-example">
            <pre><code class="language-bash">curl --request DELETE \
    "https://peopleos.test/api/teams/est" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
          </div>

          <div class="javascript-example">
            <pre><code class="language-javascript">const url = new URL(
    "https://peopleos.test/api/teams/est"
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
$url = 'https://peopleos.test/api/teams/est';
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

        <span id="example-responses-DELETEapi-teams--id-">
          <blockquote>
            <p>Example response (200):</p>
          </blockquote>
          <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;
}</code>
 </pre>
        </span>
        <span id="execution-results-DELETEapi-teams--id-" hidden>
          <blockquote>
            Received response
            <span id="execution-response-status-DELETEapi-teams--id-"></span>
            :
          </blockquote>
          <pre class="json"><code id="execution-response-content-DELETEapi-teams--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
        </span>
        <span id="execution-error-DELETEapi-teams--id-" hidden>
          <blockquote>Request failed with error:</blockquote>
          <pre><code id="execution-error-message-DELETEapi-teams--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
        </span>
        <form id="form-DELETEapi-teams--id-" data-method="DELETE" data-path="api/teams/{id}" data-authed="0" data-hasfiles="0" data-isarraybody="0" autocomplete="off" onsubmit="event.preventDefault(); executeTryOut('DELETEapi-teams--id-', this);">
          <h3>Request&nbsp;&nbsp;&nbsp;</h3>
          <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/teams/{id}</code></b>
          </p>
          <h4 class="fancy-heading-panel"><b>Headers</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Content-Type</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Content-Type" data-endpoint="DELETEapi-teams--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>Accept</code></b>
            &nbsp;&nbsp; &nbsp; &nbsp;
            <input type="text" style="display: none" name="Accept" data-endpoint="DELETEapi-teams--id-" value="application/json" data-component="header" />
            <br />
            <p>
              Example:
              <code>application/json</code>
            </p>
          </div>
          <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>id</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="id" data-endpoint="DELETEapi-teams--id-" value="est" data-component="url" />
            <br />
            <p>
              The ID of the team. Example:
              <code>est</code>
            </p>
          </div>
          <div style="padding-left: 28px; clear: unset">
            <b style="line-height: 2"><code>team</code></b>
            &nbsp;&nbsp;
            <small>string</small>
            &nbsp; &nbsp;
            <input type="text" style="display: none" name="team" data-endpoint="DELETEapi-teams--id-" value="1" data-component="url" />
            <br />
            <p>
              The ID of the team. Example:
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
