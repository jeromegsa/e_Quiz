<template>
  <Dialog
    header="Confirmer la suppression"
    :visible="isVisible"
    @hide="onHide"
    modal
    :closable="false"
  >
    <p>Êtes-vous sûr de vouloir supprimer ce quiz ?</p>
    <footer>
      <Button label="Annuler" icon="pi pi-times" @click="onCancel" />
      <Button label="Confirmer" icon="pi pi-check" @click="onConfirm" />
    </footer>
  </Dialog>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';
import { Dialog } from 'primevue/dialog';
import { Button } from 'primevue/button';

const props = defineProps({
  isVisible: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(['close', 'confirm']);

const onHide = () => {
  emit('close');
};

const onCancel = () => {
  onHide();
};

const onConfirm = () => {
  emit('confirm');
};
</script>

<style scoped>
/* Ajoutez les styles que vous souhaitez ici */
</style>
