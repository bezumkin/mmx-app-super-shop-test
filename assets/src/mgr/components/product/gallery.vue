<template>
  <div>
    <BFormFile ref="fileEl" @update:model-value="onUpdate"></BFormFile>
    <BRow class="mt-3">
      <BCol v-for="i in items" :key="i.id" cols="6" md="4" class="p-1">
        <div class="text-center">
          <BImg :src="$image(i.file, {w: 150, h: 100, fit: 'crop'})" width="150" rounded />
        </div>
        <div class="d-flex justify-content-between pt-1">
          <BButton v-if="i.active" variant="warning" size="sm" @click="onDisable(i)">
            <i class="icon icon-power-off" />
          </BButton>
          <BButton v-else size="sm" variant="success" @click="onEnable(i)"><i class="icon icon-check fa-fw" /></BButton>
          <BButton variant="danger" size="sm" @click="onDelete(i)"><i class="icon icon-times fa-fw" /></BButton>
        </div>
      </BCol>
    </BRow>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  productId: {
    type: Number,
    required: true,
  },
})

const items = ref([])
const fileEl = ref()
const url = computed(() => {
  return 'mgr/product/' + props.productId + '/files'
})

function onUpdate(file: File) {
  if (!/image\//.test(file.type)) {
    useToastError(useLexicon('errors.gallery.wrong_type'))
    return
  }

  const metadata = {
    name: file.name,
    type: file.type,
    size: file.size,
  }

  const reader = new FileReader()
  reader.readAsDataURL(file)
  reader.onload = async function () {
    try {
      await usePut(url.value, {file: reader.result, metadata})
      await loadItems()
      fileEl.value.reset()
    } catch (e) {}
  }
  reader.onerror = function (error) {
    console.log('Error: ', error)
  }
}

async function loadItems() {
  try {
    const data = await useGet(url.value)
    items.value = data.rows
  } catch (e) {}
}

async function onDisable(item: any) {
  try {
    await usePatch(url.value + '/' + item.file_id, {active: false})
    await loadItems()
  } catch (e) {}
}

async function onEnable(item: any) {
  try {
    await usePatch(url.value + '/' + item.file_id, {active: true})
    await loadItems()
  } catch (e) {}
}

async function onDelete(item: any) {
  try {
    await useDelete(url.value + '/' + item.file_id)
    await loadItems()
  } catch (e) {}
}

onMounted(loadItems)
</script>
