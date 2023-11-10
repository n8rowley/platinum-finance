<script>
export default {
    name: "SingleTransactionForm",
    props: {
        value: {
            bank_account_id: Number,
            date: String,
            amount: Number,
            description: String,
        },
        bankOptions: Array,
    },
    computed:{
        displayDate(){
            return this.value.date ? new Date(this.value.date).toLocaleDateString() : null;
        }
    },
    methods: {
        dateContextHandler(ctx){
            this.$emit('input',{
                ...this.value,
                date: ctx.yearYMD
            });
        },
        emitState(){
            this.$nextTick(()=>this.$emit('input',this.value));
        },
    },
}
</script>

<template>
    <b-form class="position-relative">
        <div class="d-flex gap-x-2">
            <b-form-group label="Bank" class="w-33">
                <b-form-select v-model="value.bank_account_id" 
                    :options="bankOptions" 
                    value-field="id"
                    text-field="name"
                    @input="emitState"></b-form-select>
            </b-form-group>

            <b-form-group label="Transaction Date" class="w-33">
                <b-input-group class="mb-3">
                    <b-form-input
                        id="example-input"
                        :value="displayDate"
                        type="text"
                        placeholder="MM/DD/YYYY"
                        autocomplete="off"
                        disabled
                    ></b-form-input>
                    <b-input-group-append>
                        <b-form-datepicker
                            v-model="value.date"
                            value-as-date
                            button-only
                            right
                            locale="en"
                            aria-controls="example-input"
                            @input="emitState"
                        ></b-form-datepicker>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>
            <b-form-group label="Amount" class="w-33">
                <b-form-input v-model="value.amount" type="number"></b-form-input>
            </b-form-group>
        </div>
        <b-form-group label="Description">
            <b-form-input v-model="value.description"></b-form-input>
        </b-form-group>
    </b-form>
</template>