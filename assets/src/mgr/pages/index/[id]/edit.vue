<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <FormsCategory v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({})

const properties = {
  url: 'mgr/categories/' + useRoute().params.id,
  title: $t('models.category.title_one'),
  updateKey: 'mgr-categories',
  method: 'patch',
}

try {
  record.value = await useGet(properties.url)
} catch (e) {
  console.error(e)
  useError()
}
</script>
