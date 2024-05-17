<template>
  <div>
    <BFormGroup :label="$t('models.category.title')">
      <BFormInput v-model="record.title" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.category.alias')">
      <MmxInputAlias v-model="record.alias" required :watch="record.title" />
    </BFormGroup>

    <BFormGroup class="mt-3">
      <BFormCheckbox v-model="record.active">{{ $t('models.category.active') }}</BFormCheckbox>
    </BFormGroup>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['update:modelValue'])
const record: any = computed({
  get() {
    return props.modelValue
  },
  set(newValue: number) {
    emit('update:modelValue', newValue)
  },
})
</script>
