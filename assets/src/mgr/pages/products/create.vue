<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <FormsProduct v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({
  title: '',
  active: true,
})

const properties = {
  url: 'mgr/products',
  title: $t('models.product.title_one'),
  method: 'put',
}
</script>
