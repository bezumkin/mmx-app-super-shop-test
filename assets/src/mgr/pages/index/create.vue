<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <FormsCategory v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({
  title: '',
  active: true,
})

const properties = {
  url: 'mgr/categories',
  title: $t('models.category.title_one'),
  method: 'put',
}
</script>
