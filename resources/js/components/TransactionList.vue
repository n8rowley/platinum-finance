<template>
    <div>
        <div class="d-flex justify-content-end gap-x-2 mb-1">
            <TransactionFilterDateRange :start-date.sync="filters.date.value.start" :end-date.sync="filters.date.value.end"/>
        </div>
        <b-table :items="transactionsProvider"
            :fields="transactionFields"
            :filter="filters"
            no-local-sort sort-icon-left
            :busy.sync="isBusy"
            small class="align-b-table-middle"
        >
            <template #head(duplicate)>
                <TransactionFilterBoolean v-model="filters.duplicate.value" true-label="Duplicate" false-label="Distinct" key="transaction-duplicate"/>
                <span style="font-size: 1.25rem;">
                    <b-icon icon="front"/>
                </span>
            </template>
            <template #cell(duplicate)="{value}">
                <b-icon v-if="value" icon="front" variant="info"/>
            </template>
            <template #head(description)="{label}">
                <TransactionFilterSearch v-model="filters.description.value" key="transaction-description"/>
                {{ label }}
            </template>
            <template #head(bank_account_id)="{label}">
                <TransactionFilterList v-model="filters.bank_account_id.value" :options="bankAccounts" text-field="name" value-field="id" key="bank-account"/>
                {{ label }}
            </template>
            <template #head(amount)="{label}">
                <TransactionFilterSearch v-model="filters.amount.value" key="transaction-amount"/>
                {{ label }}
            </template>
            <template #cell(description)="{item, value}">
                <router-link :to="{name: 'transaction-show', params: {id: item.id}}" class="tw-text-blue-500">{{ value }}</router-link>
            </template>
            <template #cell(amount)="{value}">
                <div class="d-flex justify-content-between">
                    <div class="mr-2">$</div>
                    <div>{{ value }}</div>
                </div>
            </template>
            <template #head(processed)="{label}">
                <TransactionFilterBoolean v-model="filters.processed.value" true-label="Processed" false-label="Not Processed"/>
                {{ label }}
            </template>
            <template #cell(processed)="{value}">
                <b-icon v-if="value" icon="check-square-fill"/>
                <b-icon v-else icon="square"/>
            </template>
            <template v-if="!isBusy" #custom-foot="{items}">
                <b-tr>
                    <b-th class="text-center">{{ fractionDuplicate(items) }}</b-th>
                    <b-th></b-th>
                    <b-th></b-th>
                    <b-th></b-th>
                    <b-th class="text-right">{{ totalAmount(items) }}</b-th>
                    <b-th class="text-center">{{ fractionProcessed(items) }}</b-th>
                </b-tr>
            </template>
        </b-table>
    </div>
</template>

<script>
import TransactionFilterBoolean from './sub-components/TransactionFilterBoolean.vue';
import TransactionFilterSearch from './sub-components/TransactionFilterSearch.vue';
import TransactionFilterList from './sub-components/TransactionFilterList.vue';
import TransactionFilterDateRange from './sub-components/TransactionFilterDateRange.vue';

export default {
    name: "TransactionList",
    components: { TransactionFilterBoolean, TransactionFilterSearch, TransactionFilterList, TransactionFilterDateRange },
    data() {
        return {
            filters: {
                duplicate: {type: 'exact', value: false},
                description: {type: 'search', value: null},
                bank_account_id: {type: 'list', value: []},
                date: {type: 'date-range', value: {start: "", end: ""}},
                amount: {type: 'search', value: null},
                processed: {type:'exact', value: null},
            },
            bankAccounts: [],
            transactionFields: [
                {
                    key: 'duplicate',
                    label: '',
                    thStyle: {'width':'3.25rem','text-align':'center'},
                    tdAttr: {'style': 'text-align: center;'},
                },
                {
                    key: 'description',
                    tdClass: ['flex-grow-1'],
                },
                {
                    key: 'bank_account_id',
                    label: 'Bank Account',
                    formatter: (raw) => {
                        let account = this.bankAccounts.find((account)=> account.id == raw );
                        if (account == undefined){
                            return "None"
                        }
                        return account.name;
                    },
                    thStyle: {'text-align': 'center', 'white-space': 'nowrap', width: '10rem' },
                    tdAttr: {'style': 'text-align:center;' },
                },
                {
                    key: 'date',
                    sortable: true,
                    sortDirection: 'desc',
                    formatter: (raw) => (new Date(raw)).toLocaleDateString(),
                    thStyle: {'text-align': 'center', width: '5rem' },
                    tdAttr: {'style': 'text-align:center;' },
                },
                {
                    key: 'amount',
                    sortable: true,
                    thStyle: {'text-align': 'center', width: '6rem' },
                    tdAttr: {'style': 'text-align:right;' },
                },
                {
                    key: 'processed',
                    thStyle: {'text-align': 'center', width: '6.5rem'},
                    tdAttr: {'style': 'text-align:center;' },
                },
            ],
            isBusy: null,
        }
    },
    created(){
        this.fetchBankAccounts();
    },
    methods:{
        fetchBankAccounts() {
            axios.get('/api/bankAccounts')
                .then(({data})=>{
                    this.bankAccounts = data;
                })
                .catch(console.dir);
        },
        transactionsProvider(ctx,callback){
            ctx.filter = _.omitBy(ctx.filter,f=>{
                if (f.type == 'list') {
                    return _.isEmpty(f.value);
                } else if (f.type == 'date-range'){
                    return f.start === "" && f.end === "";
                } else {
                    return f.value === null
                }
            });
            axios.get('/api/transactions',{params: ctx})
                .then(({data})=>{
                    callback(data)
                })
                .catch(()=>callback([]));
        },
        fractionDuplicate(items){
            if (!items) return;
            let duplicate = _.countBy(items,(i)=>i.duplicate);
            return `${duplicate['true'] ?? 0} / ${items.length}`;
        },
        totalAmount(items){
            if (!items) return;
            return items.reduce((acc,item)=>acc + Number(item.amount),0).toFixed(2);
        },
        fractionProcessed(items){
            if (!items) return;
            let processed = _.countBy(items,i=>i.processed);
            return `${processed['true'] ?? 0} / ${items.length}`;
        }
    }
}
</script>
