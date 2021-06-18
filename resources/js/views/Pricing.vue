<template>
    <div class="pricing-page">
        <Navbar />
        <div class="pricing-cards">
            <div v-for="(plan, n) in plans" :key="n" class="pricing-card">
                <div class="logo">
                    <font-awesome-icon icon="key" />
                </div>
                <h2 class="title">{{ plan.name }}</h2>
                <p class="price">{{ plan.currency }} ${{ plan.price }}/{{ plan.duration }}</p>
                <ul class="features">
                    <li v-for="(feature, n) in plan.features" :key="n">{{ feature }}</li>
                </ul>
                <div class="actions">
                    <b-button
                        class="subscribe-button"
                        variant="outline-info"
                    >
                    Get Started
                    </b-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import axios from 'axios';

export default {
    name: 'Pricing',
    components: {
        Navbar
    },
    data() {
        return {
            plans: null
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData() {
            axios.get('/api/plans')
            .then(res => this.plans = res.data)
            .catch(error => console.log(error));
        }
    }
    // data() {
    //     return {
    //         loaded: false,
    //         paidFor: false
    //     }
    // },
    // mounted() {
    //     const script = document.createElement("script");
    //     script.src = "https://www.paypal.com/sdk/js?client-id=Ab6LHGQELkhhEkiEmbDzTFt6tjtgvb1oIEa-zshZYBRYFbY1IiLRmoW9r1s6itUxtmrlSp45ddn5AOMP";
    //     script.addEventListener("load", this.setLoaded);
    //     document.body.appendChild(script);
    // },
    // methods: {
    //     setLoaded: function() {
    //         this.loaded = true;
            
    //         window.paypal
    //         .Buttons({
    //             CreateOrder: (data, actions) => {
    //                 return actions.order.create({
    //                    purchase_units: [
    //                        {
    //                            description: 'Test',
    //                            amount: {
    //                                currency_code: 'USD',
    //                                value: 9.99
    //                            }
    //                        }
    //                    ] 
    //                 });
    //             }
    //         })
    //         .render('.paypal-payment');
    //     }
    // }
}
</script>

<style lang="scss" scoped>
@import '/scss/pricing.scss';
</style>