<x-app-layout>
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul>
        <li class="inline">
          {{ __('Settings') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-10">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0">
      <div class="hidden space-y-6 pb-16 md:block">
        <div class="space-y-0.5">
          <h2 class="text-2xl font-bold tracking-tight">Settings</h2>
          <p class="text-muted-foreground">Manage your account settings and set e-mail preferences.</p>
        </div>

        <div class="flex flex-col space-y-8 bg-white shadow sm:rounded-lg lg:flex-row lg:space-x-12 lg:space-y-0">
          <aside class="px-4 lg:w-1/5">
            <nav class="flex space-x-2 py-3 lg:flex-col lg:space-x-0 lg:space-y-1">
              <x-link class="bg-muted inline-flex h-9 w-full items-center rounded-md bg-slate-200 px-4 py-2 text-left text-sm font-medium text-gray-900 transition-colors hover:bg-slate-50 hover:no-underline disabled:opacity-50" href="/examples/forms">{{ __('Profile and security') }}</x-link>
              <a class="inline-flex h-9 w-full items-center justify-start rounded-md px-4 py-2 text-left text-sm font-medium transition-colors hover:bg-slate-200 disabled:opacity-50" href="/examples/forms/account">{{ __('User preferences') }}</a>
              <a class="inline-flex h-9 w-full items-center justify-start rounded-md px-4 py-2 text-left text-sm font-medium transition-colors hover:bg-slate-200 disabled:opacity-50" href="/examples/forms/appearance">{{ __('API tokens') }}</a>
              <a class="inline-flex h-9 w-full items-center justify-start rounded-md px-4 py-2 text-left text-sm font-medium transition-colors hover:bg-slate-200 disabled:opacity-50" href="/examples/forms/notifications">Notifications</a>
              <a class="inline-flex h-9 w-full items-center justify-start rounded-md px-4 py-2 text-left text-sm font-medium transition-colors hover:bg-slate-200 disabled:opacity-50" href="/examples/forms/display">Display</a>
            </nav>
          </aside>
          <div class="flex-1 py-3 lg:max-w-2xl">
            <div class="space-y-6">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-medium">{{ __('Profile information') }}</h3>
                <p class="text-muted-foreground text-sm">{{ __('This is your name and personal information.') }}</p>
              </div>
              <form class="space-y-5">
                <!-- first name -->
                <div class="relative">
                  <x-input-label for="first_name" :value="__('First name')" />
                  <x-text-input class="mt-1 block w-full" id="first_name" name="first_name" type="text" required autofocus />
                  <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <!-- last name -->
                <div class="relative">
                  <x-input-label for="last_name" :value="__('Last name')" />
                  <x-text-input class="mt-1 block w-full" id="last_name" name="last_name" type="text" required autofocus />
                  <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>

                <div class="relative">
                  <x-input-label for="email" :value="__('Email')" />
                  <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  <x-help>{{ __('We will send you a verification email, and won\'t use this email for marketing purposes.') }}</x-help>
                </div>

                <!-- username -->
                <div class="space-y-2">
                  <label for="radix-v-29-form-item" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Username</label>
                  <input class="border-input placeholder:text-muted-foreground focus-visible:ring-ring flex h-9 w-full rounded-md border bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:cursor-not-allowed disabled:opacity-50" type="text" placeholder="shadcn" name="username" id="radix-v-29-form-item" aria-describedby="radix-v-29-form-item-description" aria-invalid="false" />
                  <p id="radix-v-29-form-item-description" class="text-muted-foreground text-sm">This is your public display name. It can be your real name or a pseudonym. You can only change this once every 30 days.</p>
                  <!---->
                </div>
                <div class="space-y-2">
                  <label for="radix-v-30-form-item" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                  <button
                    role="combobox"
                    type="button"
                    aria-controls="radix-vue-select-content-v-31"
                    aria-expanded="false"
                    aria-required="false"
                    aria-autocomplete="none"
                    dir="ltr"
                    data-state="closed"
                    data-placeholder=""
                    class="border-input ring-offset-background placeholder:text-muted-foreground focus:ring-ring [&amp;>span]:truncate flex h-9 w-full items-center justify-between rounded-md border bg-transparent px-3 py-2 text-start text-sm shadow-sm focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-50"
                    id="radix-v-30-form-item"
                    aria-describedby="radix-v-30-form-item-description"
                    aria-invalid="false">
                    <span style="pointer-events: none">Select an email</span>
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 opacity-50">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor"></path>
                    </svg>
                  </button>
                  <select name="email" default-value="" style="position: absolute; border: 0px; width: 1px; display: inline-block; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; overflow-wrap: normal" aria-hidden="true" tabindex="-1" value="">
                    <!---->
                    <option value="m@example.com">m@example.com</option>
                    <option value="m@google.com">m@google.com</option>
                    <option value="m@support.com">m@support.com</option>
                  </select>
                  <p id="radix-v-30-form-item-description" class="text-muted-foreground text-sm">You can manage verified email addresses in your email settings.</p>
                  <!---->
                </div>
                <div class="space-y-2">
                  <label for="radix-v-32-form-item" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bio</label>
                  <textarea class="border-input placeholder:text-muted-foreground focus-visible:ring-ring flex min-h-[60px] w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-sm disabled:cursor-not-allowed disabled:opacity-50" placeholder="Tell us a little bit about yourself" name="bio" id="radix-v-32-form-item" aria-describedby="radix-v-32-form-item-description" aria-invalid="false"></textarea>
                  <p id="radix-v-32-form-item-description" class="text-muted-foreground text-sm">
                    You can
                    <span>@mention</span>
                    other users and organizations to link to them.
                  </p>
                  <!---->
                </div>
                <div>
                  <div>
                    <div class="space-y-2">
                      <label for="radix-v-33-form-item" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">URLs</label>
                      <p id="radix-v-33-form-item-description" class="text-muted-foreground text-sm">Add links to your website, blog, or social media profiles.</p>
                      <div class="relative flex items-center">
                        <input class="border-input placeholder:text-muted-foreground focus-visible:ring-ring flex h-9 w-full rounded-md border bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:cursor-not-allowed disabled:opacity-50" type="url" name="urls[0].value" id="radix-v-33-form-item" aria-describedby="radix-v-33-form-item-description" aria-invalid="false" />
                        <button type="button" class="text-muted-foreground absolute end-0 py-2 pe-3">
                          <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-3">
                            <path
                              fill-rule="evenodd"
                              clip-rule="evenodd"
                              d="M12.8536 2.85355C13.0488 2.65829 13.0488 2.34171 12.8536 2.14645C12.6583 1.95118 12.3417 1.95118 12.1464 2.14645L7.5 6.79289L2.85355 2.14645C2.65829 1.95118 2.34171 1.95118 2.14645 2.14645C1.95118 2.34171 1.95118 2.65829 2.14645 2.85355L6.79289 7.5L2.14645 12.1464C1.95118 12.3417 1.95118 12.6583 2.14645 12.8536C2.34171 13.0488 2.65829 13.0488 2.85355 12.8536L7.5 8.20711L12.1464 12.8536C12.3417 13.0488 12.6583 13.0488 12.8536 12.8536C13.0488 12.6583 13.0488 12.3417 12.8536 12.1464L8.20711 7.5L12.8536 2.85355Z"
                              fill="currentColor"></path>
                          </svg>
                        </button>
                      </div>
                      <!---->
                    </div>
                  </div>
                  <div>
                    <div class="space-y-2">
                      <label for="radix-v-34-form-item" class="sr-only text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">URLs</label>
                      <p id="radix-v-34-form-item-description" class="text-muted-foreground sr-only text-sm">Add links to your website, blog, or social media profiles.</p>
                      <div class="relative flex items-center">
                        <input class="border-input placeholder:text-muted-foreground focus-visible:ring-ring flex h-9 w-full rounded-md border bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:cursor-not-allowed disabled:opacity-50" type="url" name="urls[1].value" id="radix-v-34-form-item" aria-describedby="radix-v-34-form-item-description" aria-invalid="false" />
                        <button type="button" class="text-muted-foreground absolute end-0 py-2 pe-3">
                          <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-3">
                            <path
                              fill-rule="evenodd"
                              clip-rule="evenodd"
                              d="M12.8536 2.85355C13.0488 2.65829 13.0488 2.34171 12.8536 2.14645C12.6583 1.95118 12.3417 1.95118 12.1464 2.14645L7.5 6.79289L2.85355 2.14645C2.65829 1.95118 2.34171 1.95118 2.14645 2.14645C1.95118 2.34171 1.95118 2.65829 2.14645 2.85355L6.79289 7.5L2.14645 12.1464C1.95118 12.3417 1.95118 12.6583 2.14645 12.8536C2.34171 13.0488 2.65829 13.0488 2.85355 12.8536L7.5 8.20711L12.1464 12.8536C12.3417 13.0488 12.6583 13.0488 12.8536 12.8536C13.0488 12.6583 13.0488 12.3417 12.8536 12.1464L8.20711 7.5L12.8536 2.85355Z"
                              fill="currentColor"></path>
                          </svg>
                        </button>
                      </div>
                      <!---->
                    </div>
                  </div>
                  <button class="focus-visible:ring-ring border-input bg-background hover:bg-accent mt-2 inline-flex h-8 w-20 items-center justify-center rounded-md border px-3 text-xs font-medium shadow-sm transition-colors disabled:opacity-50" type="button">Add URL</button>
                </div>
                <div class="flex justify-start gap-2">
                  <button class="focus-visible:ring-ring bg-primary text-primary-foreground hover:bg-primary/90 inline-flex h-9 items-center justify-center rounded-md px-4 py-2 text-sm font-medium shadow transition-colors disabled:opacity-50" type="submit">Update profile</button>
                  <button class="focus-visible:ring-ring border-input bg-background hover:bg-accent inline-flex h-9 items-center justify-center rounded-md border px-4 py-2 text-sm font-medium shadow-sm transition-colors disabled:opacity-50" type="button">Reset form</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
