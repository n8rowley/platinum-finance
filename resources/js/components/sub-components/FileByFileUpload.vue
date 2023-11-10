<script>
export default {
    name: "statement-upload",
    data(){return{
        bankOptions: [],
        files: [{bankAccount: null, file: null}],
    }},
    created(){
        axios({
            method: "GET",
            url: "/api/bankAccounts",
            params: {
                only_mappable: true,
            }
        }).then(({data})=>{
            this.bankOptions = data;
        })
    },
    methods: {
        addFile() {
            this.files.push({ bankAccount: null, file: null });
        },
        upload(){
            axios({
                method: "POST",
                url: "/api/upload-statements",
                data: {
                    files: this.files
                },
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then(({data})=>{
                this.$emit('imported',data);
                this.files = [{bankAccount: null, file: null}];
            })
        }
    }
}
</script>

<template>
    <div>
        <div v-for="(file, index) in files" :key="index" class="d-flex gap-x-4 align-items-center rounded-pill border-2 border-primary py-2 pr-4 pl-2 mb-4">
            <div style="width: 1rem;">
                <b-icon v-if="index > 0" icon="x-lg" @click="files.splice(index,1)"></b-icon>
            </div>
            <b-select v-model="file.bankAccount" :options="bankOptions" text-field="name" value-field="id" class="w-25">
                <template #first>
                    <b-select-option :value="null">--Select Bank--</b-select-option>
                </template>
            </b-select>
            <b-form-file v-model="file.file" accept=".csv, .txt"></b-form-file>
        </div>
        <div class="d-flex justify-content-end gap-x-2">
            <b-button @click="addFile">Add File</b-button>
            <b-button variant="primary" @click="upload">Submit</b-button>
        </div>
    </div>
</template>
