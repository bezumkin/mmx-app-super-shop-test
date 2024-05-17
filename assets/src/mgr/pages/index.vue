<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, rowClass}">
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const url = 'mgr/categories'
const table = ref()
const headerActions = computed(() => {
  return [{route: {name: 'index-create'}, icon: 'plus', title: $t('models.category.title_one')}]
})
const fields = computed(() => {
  return [
    {key: 'id', label: $t('models.category.id'), sortable: true},
    {key: 'title', label: $t('models.category.title'), sortable: true},
    {key: 'created_at', label: $t('models.category.created_at'), sortable: true, formatter: formatDate},
    {key: 'updated_at', label: $t('models.category.updated_at'), sortable: true, formatter: formatDate},
  ]
})
const tableActions = computed(() => {
  return [
    {route: {name: 'index-id-edit'}, icon: 'edit', title: $t('actions.edit')},
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: ''})

function rowClass(item: any) {
  return item && !item.active ? 'inactive' : ''
}
</script>
