<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Update a person's physical appearance</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#update-physical-appearance" class="text-blue-500 hover:underline">Update a person's physical appearance</a>
      </li>
    </ul>
  </div>

  <!-- introduction -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you update the physical appearance information of a person.</p>
      <p class="mb-10">You can update any combination of physical attributes such as height, weight, build, facial features, and other physical characteristics. All fields are optional, however any fields that is not explicitely passed as arguments will be set to null.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#update-physical-appearance">
            <span class="text-yellow-700">PATCH</span>
            /api/persons/{person}/physical-appearance
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PATCH /api/persons/{person}/physical-appearance -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-physical-appearance" class="mb-2 text-lg font-bold">Update a person's physical appearance</h3>
      <p class="mb-10">This endpoint updates the physical appearance information of a person. It will return the updated person in the response.</p>

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
          <x-marketing.attribute name="height" type="string" description="The height of the person (e.g., '6'0\"')." />
          <x-marketing.attribute name="weight" type="string" description="The weight of the person (e.g., '175 lbs')." />
          <x-marketing.attribute name="build" type="string" description="The body build of the person (e.g., 'Athletic', 'Slim')." />
          <x-marketing.attribute name="skin_tone" type="string" description="The skin tone of the person." />
          <x-marketing.attribute name="face_shape" type="string" description="The face shape of the person (e.g., 'Oval', 'Round')." />
          <x-marketing.attribute name="eye_color" type="string" description="The eye color of the person." />
          <x-marketing.attribute name="eye_shape" type="string" description="The eye shape of the person (e.g., 'Almond', 'Round')." />
          <x-marketing.attribute name="hair_color" type="string" description="The hair color of the person." />
          <x-marketing.attribute name="hair_type" type="string" description="The hair type of the person (e.g., 'Straight', 'Curly')." />
          <x-marketing.attribute name="hair_length" type="string" description="The hair length of the person (e.g., 'Short', 'Long')." />
          <x-marketing.attribute name="facial_hair" type="string" description="Description of the person's facial hair, if any." />
          <x-marketing.attribute name="scars" type="string" description="Description of any scars the person may have." />
          <x-marketing.attribute name="tatoos" type="string" description="Description of any tattoos the person may have." />
          <x-marketing.attribute name="piercings" type="string" description="Description of any piercings the person may have." />
          <x-marketing.attribute name="distinctive_marks" type="string" description="Any distinctive marks or features not covered by other fields." />
          <x-marketing.attribute name="glasses" type="string" description="Whether the person wears glasses and details about them." />
          <x-marketing.attribute name="dress_style" type="string" description="The typical dress style of the person." />
          <x-marketing.attribute name="voice" type="string" description="Description of the person's voice characteristics." />
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
          <x-marketing.attribute name="age" type="object" description="The age information of the person." />
          <x-marketing.attribute name="how_we_met" type="string" description="How you met this person." />
          <x-marketing.attribute name="can_be_deleted" type="boolean" description="Whether the person can be deleted." />
          <x-marketing.attribute name="is_listed" type="boolean" description="Whether the person is listed." />
          <x-marketing.attribute name="physical_appearance" type="object" description="The physical appearance information of the person." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/physical-appearance" verb="PATCH" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.person-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
