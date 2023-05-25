<template>
    <div class="border my-4 p-3 rounded-3">
        <h3 class="my-3">Cena zakupu</h3>
        <div class="row">
            <div class="col-12 col-md-4">
                <label>Cena</label>
                <input @change="calculate" type="number" step="0.01" v-model="buyPrice" class="form-control">
            </div>
            <div class="col-12 col-md-4">
                <label>Stawka VAT</label>
                <input @change="calculate" type="number" step="1" v-model="vat" class="form-control">
            </div>
            <div class="col-12 col-md-4">
                <label for="isGross">Czy cena brutto</label>
                <input @change="calculate" type="checkbox" class="form-check" v-model="isBuyGross" id="isGross">
            </div>
        </div>
        <h3 class="my-3">Cena sprzedaży</h3>
        <div class="row">
            <div class="col-12 col-md-4">
                <label>Cena</label>
                <input @change="calculate" type="number" step="0.01" v-model="sellPrice" class="form-control">
            </div>
            <div class="col-12 col-md-4">
                <label>Stawka VAT</label>
                <input @change="calculate" type="number" step="1" v-model="vat" class="form-control">
            </div>
            <div class="col-12 col-md-4">
                <label for="isGross">Czy cena brutto</label>
                <input @change="calculate" type="checkbox" class="form-check" v-model="isSellGross" id="isGross">
            </div>
        </div>
    </div>
    <div class="border my-4 p-3 rounded-3" v-if="sellPrice && buyPrice">
        <h2 class="text-uppercase text-center">Wyniki</h2>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Pole</th>
                <th>Wartość</th>
                <th>Sposób obliczenia</th>
                <th>Wzór</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Cena zakupu netto</td>
                <td>{{ buyNetPrice }}</td>
                <td>
                    {{ buyGrossPrice }} / (1 + {{ vat }} / 100)
                </td>
                <td>
                    cena zakupu brutto / (1 + vat / 100)
                </td>
            </tr>
            <tr>
                <td>Cena zakupu brutto</td>
                <td>{{ buyGrossPrice }}</td>
                <td>
                    {{ buyNetPrice }} * (1 + {{ vat }} / 100)
                </td>
                <td>
                    cena zakupu netto * (1 + vat / 100)
                </td>
            </tr>
            <tr>
                <td>Cena sprzedaży netto</td>
                <td>{{ sellNetPrice }}</td>
                <td>
                    {{ sellGrossPrice }} / (1 + {{ vat }} / 100)
                </td>
                <td>
                    cena sprzedaży brutto / (1 + vat / 100)
                </td>
            </tr>
            <tr>
                <td>Cena sprzedaży brutto</td>
                <td>{{ sellGrossPrice }}</td>
                <td>
                    {{ sellNetPrice }} * (1 + {{ vat }} / 100)
                </td>
                <td>
                    cena sprzedaży netto * (1 + vat / 100)
                </td>
            </tr>
            <tr>
                <td>Marża</td>
                <td>{{ margin }}</td>
                <td>({{sellNetPrice}} - {{ buyNetPrice }}) / {{ sellNetPrice }} * 100</td>
                <td>(cena sprzedaży - cena zakupu) / cena sprzedaży * 100</td>
            </tr>
            <tr>
                <td>Narzut</td>
                <td>{{ markup }}</td>
                <td>({{sellNetPrice}} - {{ buyNetPrice }}) / {{ buyNetPrice }} * 100</td>
                <td>(cena sprzedaży - cena zakupu) / cena zakupu * 100</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


<!--<script>-->
<!--export default {-->
<!--    name: "CalculateMargin"-->
<!--}-->
<!--</script>-->
<script setup lang="ts">
import {computed, onMounted, Ref, ref, UnwrapRef} from 'vue'

let vat: Number = 23;
let isBuyGross: Ref<UnwrapRef<boolean>> = ref(false);
let isSellGross: Ref<UnwrapRef<boolean>> = ref(false);
let buyPrice = ref(100);
let sellPrice = ref(150);
let buyNetPrice = ref(0);
let buyGrossPrice = ref(0);
let sellNetPrice = ref(0);
let sellGrossPrice = ref(0);
let markup = ref(0);
let margin = ref(0);

const calculateBuyNet = (): void => {
    buyGrossPrice.value = buyPrice.value * (1 + (vat / 100));
    buyNetPrice.value = buyPrice.value
}
const calculateBuyGross = (): void => {
    buyNetPrice.value = Math.round(buyPrice.value / (1 + (vat / 100)) * 100) / 100;
    buyGrossPrice.value = buyPrice.value;
}

const calculateSellNet = (): void => {
    sellGrossPrice.value = sellPrice.value * (1 + (vat / 100));
    sellNetPrice.value = sellPrice.value
}
const round = value => Math.round(value * 100 ) / 100;
const calculateSellGross = (): void => {
    sellNetPrice.value = Math.round(sellPrice.value / (1 + (vat / 100)) * 100) / 100;
    sellGrossPrice.value = sellPrice.value;
}
const calculate = (): void => {
    isBuyGross.value ? calculateBuyGross() : calculateBuyNet()
    isSellGross.value ? calculateSellGross() : calculateSellNet()
    margin.value = round( (sellGrossPrice.value - buyGrossPrice.value) / sellGrossPrice.value * 100)
    markup.value = round((sellGrossPrice.value - buyGrossPrice.value) / buyGrossPrice.value * 100)
}
onMounted(() => calculate())

</script>
<style scoped>

</style>
