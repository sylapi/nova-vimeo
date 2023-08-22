<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <input
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        placeholder="Vimeo ID"
        v-model="vimeo_id"
        @change="grab"
      />
    </template>  
  </DefaultField>
  <DefaultField
    :field="field"
    :fieldName="field.fields.thumbnail.name"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <input
        :id="field.fields.thumbnail.attribute"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.fields.thumbnail.name"
        v-model="thumbnail"
      />
    </template>  
  </DefaultField>
  <DefaultField
    :field="field"
    :fieldName="field.fields.vimeo.name"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <input
        :id="field.fields.vimeo.attribute"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.fields.vimeo.name"
        v-model="vimeo"
      />
    </template>  
  </DefaultField>
  <DefaultField
    :field="field"
    :fieldName="field.fields.vimeo_hls.name"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <input
        :id="field.fields.vimeo_hls.attribute"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.fields.vimeo_hls.name"
        v-model="vimeo_hls"
      />
    </template>  
  </DefaultField>
  <DefaultField
    :field="field"
    :fieldName="field.fields.vimeo_dash.name"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <input
        :id="field.fields.vimeo_dash.attribute"
        :label="field.fields.vimeo_dash.name"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.fields.vimeo_dash.name"
        v-model="vimeo_dash"
      />
    </template>  
  </DefaultField>    
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
        return {
          thumbnail: null,
          vimeo: null,
          vimeo_hls: null,
          vimeo_dash: null,
        }
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.thumbnail  = this.field.fields.thumbnail.value ?? '';
      this.vimeo  = this.field.fields.vimeo.value ?? '';
      this.vimeo_hls = this.field.fields.vimeo_hls.value ?? '';
      this.vimeo_dash = this.field.fields.vimeo_dash.value ?? '';
    },

    /**
     * Update the internal value for the field.
     */ 

    async grab() {
      try {
        const response = await fetch("/nova-vendor/sylapi/vimeo/vimeo/" + this.vimeo_id, {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        });

        const result = await response.json();

        this.thumbnail = result.thumbnail;
        this.vimeo = result.vimeo;
        this.vimeo_hls = result.vimeo_hls;
        this.vimeo_dash = result.vimeo_dash;
        
      } catch (error) {
        console.error("Error:", error);
      }
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.thumbnail_attr, this.thumbnail || '')
      formData.append(this.field.vimeo_attr, this.vimeo || '')
      formData.append(this.field.vimeo_hls_attr, this.vimeo_hls || '')
      formData.append(this.field.vimeo_dash_attr, this.vimeo_dash || '')
    },

  },
}
</script>
