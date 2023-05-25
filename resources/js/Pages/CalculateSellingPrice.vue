<template>
    <div class="border my-4 p-3 rounded-3">
        <h3 class="my-3">Podaj marżę lub narzut</h3>
        <div class="row">
            <div class="col-12 col-md-4">
                <label>Marża lub narzut</label>
                <select class="form-select" v-model="marginOrMarkup">
                    <option :value="1">Marża</option>
                    <option :value="2">Narzut</option>
                </select>
            </div>
            <div class="col-12 col-md-4" v-if="marginOrMarkup===1">
                <label>Marża</label>
                <input @change="calculate" type="number" step="0.01" v-model="margin" class="form-control">
            </div>
            <div class="col-12 col-md-4" v-if="marginOrMarkup===2">
                <label>Narzut</label>
                <input @change="calculate" type="number" step="1" v-model="markup" class="form-control">
            </div>

        </div>
        <h3 class="my-3">Cena Zakupu</h3>
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
                <input @change="calculate" type="checkbox" class="form-check" v-model="isSellGross" id="isGross">
            </div>
        </div>
    </div>
    <div class="border my-4 p-3 rounded-3" v-if="buyPrice && (margin || markup)">
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
            <tr v-if="marginOrMarkup === 1">
                <td>Marża</td>
                <td>{{ margin }}</td>
                <td></td>
                <td>Wartość wprowadzona wyżej</td>
            </tr>
            <tr v-else>
                <td>Narzut</td>
                <td>{{ markup }}</td>
                <td></td>
                <td>Wartość wprowadzona wyżej</td>
            </tr>
            <tr>
                <td>Cena sprzedaży netto</td>
                <td>{{ sellNetPrice }}</td>
                <td v-if="marginOrMarkup === 2">
                    {{ buyNetPrice }} * {{ markup }} / 100 + {{ buyNetPrice }}
                </td>
                <td v-else>
                    {{ buyNetPrice }} / (1 - {{ margin }} / 100)
                </td>
                <td v-if="marginOrMarkup === 2">
                    <button @click="markupProof = !markupProof" class="btn btn-success">
                        {{ markupProof ? 'Ukryj' : 'Pokaż' }} wyprowadzenie
                    </button>
                    <code :class="markupProof ? 'd-block' : 'd-none'">
                        narzut = (cena sprzedaży - cena zakupu) / cena zakupu * 100 <br/>
                        narzut / 100 * cena zakupu = cena sprzedaży - cena zakupu <br/>
                        cena sprzedaży = narzut / 100 * cena zakupu + cena zakupu
                    </code>
                    <span class="d-block">
                        cena sprzedaży = narzut / 100 * cena zakupu + cena zakupu
                    </span>
                </td>
                <td v-else>
                    <button @click="marginProof = !marginProof" class="btn btn-success">
                        {{ marginProof ? 'Ukryj' : 'Pokaż' }} wyprowadzenie
                    </button>
                    <code :class="marginProof ? 'd-block' : 'd-none'">
                        marża = (cena sprzedaży - cena zakupu) / cena sprzedaży * 100 <br/>
                        marża / 100 * cena sprzedaży = cena sprzedaży - cena zakupu <br/>
                        cena zakupu = cena sprzedaży - marża / 100 * cena sprzedaży <br/>
                        cena zakupu = cena sprzedaży * (1 - marża / 100) <br/>
                        cena sprzedaży = cena zakupu / (1 - marża / 100)
                    </code>
                    <span class="d-block">
                        cena sprzedaży = cena zakupu / (1 - marża / 100)
                    </span>
                </td>
            </tr>
            <tr>
                <td>Cena sprzedaży brutto</td>
                <td>{{ sellGrossPrice }}</td>
                <td>
                    {{ buyNetPrice }} * (1 + {{ vat }} / 100)
                </td>
                <td>
                    cena zakupu netto * (1 + vat / 100)
                </td>
            </tr>

            <tr v-if="marginOrMarkup === 2">
                <td>Marża</td>
                <td>{{ marginResult }}</td>
                <td>({{sellNetPrice}} - {{ buyNetPrice }}) / {{ sellNetPrice }} * 100</td>
                <td>(cena sprzedaży - cena zakupu) / cena sprzedaży * 100</td>
            </tr>
            <tr v-else>
                <td>Narzut</td>
                <td>{{ markupResult }}</td>
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
let marginOrMarkup = ref(2);
let buyPrice = ref(100);
let sellPrice = ref(0);
let buyNetPrice = ref(0);
let buyGrossPrice = ref(0);
let sellNetPrice = ref(0);
let sellGrossPrice = ref(0);
let markup = ref(50);
let margin = ref(33);
let marginResult = ref(0)
let markupResult = ref(0)

let markupProof = ref(false)
let marginProof = ref(false)

const calculateBuyMargin = (): void => {
    sellNetPrice.value = round(buyNetPrice.value / (1 - margin.value / 100))
    sellGrossPrice.value = round(sellNetPrice.value * (1 + (vat / 100)));
    marginResult = margin
}
const calculateBuyMarkup = (): void => {
    sellNetPrice.value = round(buyNetPrice.value * markup.value / 100 + buyNetPrice.value)
    sellGrossPrice.value = round(sellNetPrice.value * (1 + (vat / 100)));
    markupResult = markup
}

const calculateBuyNet = (): void => {

    buyGrossPrice.value = buyPrice.value * (1 + (vat / 100));
    buyNetPrice.value = buyPrice.value
}
const round = value => Math.round(value * 100 ) / 100;
const calculateBuyGross = (): void => {
    buyNetPrice.value = Math.round(buyPrice.value / (1 + (vat / 100)) * 100) / 100;
    buyGrossPrice.value = buyPrice.value;
}
const calculate = (): void => {
    isSellGross.value ? calculateBuyGross() : calculateBuyNet()
    marginOrMarkup.value === 1 ? calculateBuyMargin() : calculateBuyMarkup()
    if (marginOrMarkup.value === 2) {
        marginResult.value = round( (sellGrossPrice.value - buyGrossPrice.value) / sellGrossPrice.value * 100)
    } else {
        markupResult.value = round((sellGrossPrice.value - buyGrossPrice.value) / buyGrossPrice.value * 100);
    }
}
onMounted(() => calculate())

</script>
<style scoped>

</style>
