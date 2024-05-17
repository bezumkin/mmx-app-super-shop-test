<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, rowClass}">
    <template #cell(file)="{value}">
      <BImg v-if="value" :src="$image(value, {w: 75, fit: 'crop'})" width="75" rounded />
    </template>
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const url = 'mgr/products'
const table = ref()
const headerActions = computed(() => {
  return [{route: {name: 'products-create'}, icon: 'plus', title: $t('models.product.title_one')}]
})
const fields = computed(() => {
  return [
    {key: 'id', label: $t('models.product.id'), sortable: true},
    {key: 'file', label: ''},
    {key: 'title', label: $t('models.product.title'), sortable: true},
    {key: 'uri', label: $t('models.product.uri'), sortable: true},
    {key: 'created_at', label: $t('models.product.created_at'), sortable: true, formatter: formatDate},
    {key: 'updated_at', label: $t('models.product.updated_at'), sortable: true, formatter: formatDate},
  ]
})
const tableActions = computed(() => {
  return [
    {route: {name: 'products-id-edit'}, icon: 'edit', title: $t('actions.edit')},
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: ''})

function rowClass(item: any) {
  return item && !item.active ? 'inactive' : ''
}
</script>
