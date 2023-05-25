<template>
    <ul class="nav nav-tabs my-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Oblicz marżę i narzut
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Oblicz cenę zakupu
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                    role="tab" aria-controls="contact" aria-selected="false">Oblicz cenę sprzedaży
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <CalculateMargin/>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <CalculatePurchasePrice/>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <CalculateSellingPrice/>
        </div>

    </div>
</template>
<style>

</style>


<script>
import CalculateMargin from "./CalculateMargin.vue";
import CalculateSellingPrice from "./CalculateSellingPrice.vue";
import CalculatePurchasePrice from "./CalculatePurchasePrice.vue";
export default {
    components: {CalculatePurchasePrice, CalculateSellingPrice, CalculateMargin}
}
</script>
