<script>
import BankAccountManager from './sub-components/BankAccountManager.vue';
import CategoryManager from './sub-components/CategoryManager.vue';

export default {
    name: "user-settings",
    components: { CategoryManager,BankAccountManager },
    data(){return{
        categoriesVisible: true,
        bankAccountsVisible: true,
    }},
}
</script>

<template>
    <div>
        <div class="rounded-lg bg-secondary text-dark p-2 mb-4">
            <div class="border border-dark p-2 rounded-lg cursor-pointer">
                <div class="text-lg d-flex gap-x-2 align-items-center" @click="categoriesVisible = !categoriesVisible">
                    <b-icon v-if="categoriesVisible" icon="chevron-down"></b-icon>
                    <b-icon v-else icon="chevron-right"></b-icon>
                    Categories
                </div>
            </div>
            <b-collapse v-model="categoriesVisible">
                <category-manager></category-manager>
            </b-collapse>
        </div>
        <div class="rounded-lg bg-secondary text-dark p-2">
            <div class="border border-dark p-2 rounded-lg cursor-pointer">
                <div class="text-lg d-flex gap-x-2 align-items-center" @click="bankAccountsVisible = !bankAccountsVisible">
                    <b-icon v-if="bankAccountsVisible" icon="chevron-down"></b-icon>
                    <b-icon v-else icon="chevron-right"></b-icon>
                    Bank Accounts
                </div>
            </div>
            <b-collapse v-model="bankAccountsVisible">
                <bank-account-manager></bank-account-manager>
            </b-collapse>
        </div>
    </div>
</template>
