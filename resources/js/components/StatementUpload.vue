<template>
    <div class="h-100  overflow-auto">
        <b-button class="mb-4" @click="n++">Add File</b-button>
        <div v-for="i in n" :key="i" class="d-flex gap-x-4 rounded-pill border-2 border-primary py-2 px-4 mb-4">
            <b-select :value="null" :options="[{text: '--Select Bank--', value: null, disabled: true},{text: 'Zions', value: 1}, {text: 'Southwest', value: 2}]" class="w-25"></b-select>
            <b-form-file></b-form-file>
        </div>
        <b-button variant="primary">Submit</b-button>
    </div>
</template>

<script>
export default {
    name: "statement-upload",
    data(){return{
        n: 1
    }}
}
</script>