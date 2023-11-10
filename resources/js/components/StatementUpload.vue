<script>
import FileByFileUpload from './sub-components/FileByFileUpload.vue'
import TransactionByTransactionUpload from './sub-components/TransactionByTransactionUpload.vue';

export default {
    name: "statement-upload",
    components: { FileByFileUpload, TransactionByTransactionUpload },
    data(){return{
        importStatistics: null,
    }},
}
</script>

<template>
    <div>
        <b-alert v-if="importStatistics" variant="success" show dismissible @dismissed="importStatistics = null">
            <h3>Imports</h3>
            <div v-for="(file,index) in importStatistics" :key="index">
                <span>{{file.account_name}}: </span>
                <span>{{file.created}} Created - </span>
                <span>{{file.total - file.created}} Duplicate - </span>
                <span>({{file.total}} Total)</span>
            </div>
        </b-alert>
        <b-tabs>
            <b-tab title="By File" active class="p-4"><file-by-file-upload @imported="importStatistics = $event"/></b-tab>
            <b-tab title="By Transaction" class="p-4"><transaction-by-transaction-upload @imported="importStatistics = $event"/></b-tab>
        </b-tabs>
    </div>
</template>