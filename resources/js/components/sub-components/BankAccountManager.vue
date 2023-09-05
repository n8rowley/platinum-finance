<script>
import EditableCategory from './EditableCategory.vue';

export default {
    name: "bank-account-manager",
    components: { EditableCategory },
    props:{},
    data(){return {
        bankAccounts: [
            {
                id: 3,
                name: "Zions", 
                mapping: {
                    headerLines: 3,
                    date: 0,
                    description: 1,
                    amount: 4,
                    amount2: 5,
                    splitAmount: true,
                },
                enabled: true,
            },
            {
                id: 2,
                name: "Southwest",
                mapping: {
                    headerLines: 2,
                    date: 1,
                    description: 3,
                    amount: 5,
                    splitAmount: false,
                },
                enabled: true,
            },
            {
                id: 1,
                name: "Discover",
                mapping: {
                    headerLines: 2,
                    date: 1,
                    description: 3,
                    amount: 5,
                    splitAmount: false,
                },
                enabled: false,
            }
        ],
        activeBank: {},
        showDisabled: false,
    }},
    methods: {
        insertBankAccount(){
            this.bankAccounts = [
                ...this.bankAccounts,
                {name: null, enabled: true, mapping: {}},
            ]
        }
    },
    computed: {
        enabledBankAccounts(){
            return this.bankAccounts.filter((item)=>item.enabled);
        },
        disabledBankAccounts(){
            return this.bankAccounts.filter((item)=>!item.enabled);
        },
        activeMapping(){
            return this.activeBank.mapping ?? {};
        }
    }
}
</script>

<template>
    <div class="p-4 d-flex">
        <div class="w-25 d-flex flex-column gap-y-2 pr-4 border-right border-dark">
            <editable-category v-for="bank in enabledBankAccounts" :key="bank.id" :value="bank" :active="activeBank.id == bank.id" @clicked="activeBank = bank"></editable-category>
            <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertBankAccount">Add new bank +</div>
            <b-button variant="link" @click="showDisabled = !showDisabled">{{showDisabled ? 'Hide' : 'View'}} Inactive Bank Accounts</b-button>
            <b-collapse v-model="showDisabled">
                <div class="d-flex flex-column gap-y-2">
                    <editable-category v-for="bank in disabledBankAccounts" :key="bank.id" :value="bank" :active="activeBank.id == bank.id" @clicked="activeBank = bank"></editable-category>
                </div>
            </b-collapse>
        </div>
        <div v-if="!!activeBank" class="flex-grow-1 pl-4">
            <b-form class="gap-x-4" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));">
                <b-form-group label="Header Lines">
                    <b-form-input type="number" v-model="activeMapping.headerLines"></b-form-input>
                </b-form-group>
                <b-form-group label="Date Column">
                    <b-form-input type="number" v-model="activeMapping.date"></b-form-input>
                </b-form-group>
                <b-form-group label="Description Column">
                    <b-form-input type="number" v-model="activeMapping.description"></b-form-input>
                </b-form-group>
                <b-form-checkbox v-model="activeMapping.splitAmount">Deposit and Withdrawal are split</b-form-checkbox>
                <b-form-group label="Amount Column">
                    <b-form-input type="number" v-model="activeMapping.amount"></b-form-input>
                </b-form-group>
                <b-form-group :disabled="!activeMapping.splitAmount" label="Amount 2 Column">
                    <b-form-input type="number" v-model="activeMapping.amount2"></b-form-input>
                </b-form-group>
            </b-form>
            <b-button pill variant="accent">Save</b-button>
        </div>
    </div>
</template>