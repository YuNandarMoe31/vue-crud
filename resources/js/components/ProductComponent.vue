<template>
    <div class="container my-5">
        <div class="row justify-content-end mb-3">
            <div class="col-4">
                <button class="btn btn-primary" @click="create"><i class="fas fa-plus-circle m-1"></i>Create</button>
            </div>
            <div class="col-4">
                <form>
                    <div class="input-group">
                        <input type="text" placeholder="Search" class="form-control" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <h4 class="card-header">{{ isEditMode ? "Edit" : "Create" }}</h4>
                    <div class="card-body">
                        <!--<alert-error :form="product" :message="message"></alert-error>-->
                        <form @submit.prevent="isEditMode ? update() : store()">
                            <div class="form-group">
                                <label>Name: </label>
                                <input v-model="product.name" type="text" class="form-control" />
                                <template v-if="errors.name">
                                    <p class="text-danger text-sm" v-text="errors.name"></p>
                                </template>
                            </div>
                            <div class="form-group mt-3">
                                <label>Price: </label>
                                <input v-model="product.price" type="number" class="form-control" />
                                <template v-if="errors.price">
                                    <p class="text-danger" v-text="errors.price"></p>
                                </template>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 py-2">
                                <i class="fas fa-save m-1"></i>
                                {{ isEditMode ? "Update" : "Save" }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                                <button class="btn btn-success btn-sm mx-1" @click="edit(product)">
                                    <i class="fas fa-edit m-1"></i>Edit
                                </button>
                                <button class="btn btn-danger btn-sm mx-1" @click="destroy(product.id)">
                                    <i class="fas fa-trash-alt m-1"></i>Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    name: 'ProductComponent',
    data() {
        return {
            isEditMode: false,
            products: [],
            product: {
                name: '',
                price: '',
                id: ''
            },
            errors:{},
        }
    },
    methods: {
        view() {
            axios.get('/api/product')
                .then(response => {
                    this.products = response.data
                })
        },
        create() {
            this.errors = {}
            this.isEditMode = false;
            this.product.id = "";
            this.product.name = "";
            this.product.price = "";
        },
        store() {
            axios.post('/api/product', this.product)
                .then(response => {
                    this.view();
                    this.product.id = "";
                    this.product.name = "";
                    this.product.price = "";
                }).catch(error => {
                    if (error.response) {
                        let errors = error.response.data.errors;
                        for (let key in errors) {
                            this.errors[key] = errors[key][0]
                        }
                    }
                });
        },
        edit(product) {
            this.errors = {}
            this.isEditMode = true;
            this.product.id = product.id;
            this.product.name = product.name;
            this.product.price = product.price;
        },
        update() {
            this.errors = {}
            axios.put(`/api/product/${this.product.id}`, this.product)
                .then(response => {
                    this.view();
                    this.product.id = "";
                    this.product.name = "";
                    this.product.price = "";
                }).catch(error => {
                    if (error.response) {
                        let errors = error.response.data.errors;
                        for (let key in errors) {
                            this.errors[key] = errors[key][0]
                        }
                    }
                });
        },
        destroy(id) {
            if (!confirm("Are you sure you want to delete?")) {
                return;
            }
            axios.delete(`/api/product/${id}`)
                .then(response => this.view());
        },
    },
    created() {
        this.view();
    }
};
</script>