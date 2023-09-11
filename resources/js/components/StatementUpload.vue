<script>
import FileByFileUpload from './sub-components/FileByFileUpload.vue'
import TransactionByTransactionUpload from './sub-components/TransactionByTransactionUpload.vue';

export default {
    name: "statement-upload",
    components: { FileByFileUpload, TransactionByTransactionUpload },
}
</script>

<template>
    <b-tabs>
        <b-tab title="By File" active class="p-4"><file-by-file-upload/></b-tab>
        <b-tab title="By Transaction" class="p-4"><transaction-by-transaction-upload/></b-tab>
    </b-tabs>
</template>