<x-marketing-docs-layout>
  <h1 class="mb-6 text-2xl font-bold">Update a person's age</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#update-age" class="text-blue-500 hover:underline">Update a person's age</a>
      </li>
    </ul>
  </div>

  <!-- introduction -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you update the age information of a person.</p>
      <p class="mb-10">You can set an exact age (with birth date), an estimated age, or an age bracket. When setting an exact age, you can optionally add a yearly reminder for the person's birthday.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#update-age">
            <span class="text-yellow-700">PATCH</span>
            /api/persons/{person}/age
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PATCH /api/persons/{person}/age -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-age" class="mb-2 text-lg font-bold">Update a person's age</h3>
      <p class="mb-10">This endpoint updates the age information of a person. It will return the updated person in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="age_type" type="string" description="Type of age information. Must be one of: 'exact', 'estimated', or 'bracket'." />
          <x-marketing.attribute name="age_year" type="integer" description="Required when age_type is 'exact'. The birth year." />
          <x-marketing.attribute name="age_month" type="integer" description="Optional when age_type is 'exact'. The birth month (1-12)." />
          <x-marketing.attribute name="age_day" type="integer" description="Optional when age_type is 'exact'. The birth day (1-31)." />
          <x-marketing.attribute name="estimated_age" type="integer" description="Required when age_type is 'estimated'. The estimated age in years." />
          <x-marketing.attribute name="age_bracket" type="string" description="Required when age_type is 'bracket'. The age bracket (e.g., '18-25')." />
          <x-marketing.attribute required name="add_yearly_reminder" type="boolean" description="Whether to add a yearly reminder for the person's birthday." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="id" type="integer" description="The ID of the person." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'person'." />
          <x-marketing.attribute name="name" type="string" description="The full name of the person." />
          <x-marketing.attribute name="first_name" type="string" description="The first name of the person." />
          <x-marketing.attribute name="last_name" type="string" description="The last name of the person." />
          <x-marketing.attribute name="middle_name" type="string" description="The middle name of the person." />
          <x-marketing.attribute name="nickname" type="string" description="The nickname of the person." />
          <x-marketing.attribute name="maiden_name" type="string" description="The maiden name of the person." />
          <x-marketing.attribute name="prefix" type="string" description="The name prefix of the person." />
          <x-marketing.attribute name="suffix" type="string" description="The name suffix of the person." />
          <x-marketing.attribute name="age" type="mixed" description="The age information of the person." />
          <x-marketing.attribute name="how_we_met" type="string" description="How you met this person." />
          <x-marketing.attribute name="can_be_deleted" type="boolean" description="Whether the person can be deleted." />
          <x-marketing.attribute name="is_listed" type="boolean" description="Whether the person is listed." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/age" verb="PATCH" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.person-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>
</x-marketing-docs-layout>
