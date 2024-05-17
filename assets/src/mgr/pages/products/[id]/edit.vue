<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <BTabs content-class="pt-3">
        <BTab :title="$t('models.product.title_one')">
          <FormsProduct v-model="record" />
        </BTab>
        <BTab :title="$t('models.product.gallery')">
          <ProductGallery :product-id="record.id" />
        </BTab>
      </BTabs>
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({})

const properties = {
  url: 'mgr/products/' + useRoute().params.id,
  title: $t('models.product.title_one'),
  updateKey: 'mgr-products',
  method: 'patch',
}

try {
  record.value = await useGet(properties.url)
} catch (e) {
  console.error(e)
  useError()
}
</script>
