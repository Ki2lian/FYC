<template>
    <div>
        <div id="formTag" ref="form" @submit.prevent="addTag"></div>

        <table class="table">
            <thead>
            <th>Nom</th>
            <th>Action</th>
            </thead>
            <tbody>
            <tr v-for="(tag, index) in tags" :key="tag.id">
                <td>
                    <input type="text" class="form-control w-50" readonly :value="tag.name" @input="update(index, 'name', $event.target.value)"/>
                </td>
                <td>
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-2" @click="toggleReadonly($event)">Edit</button>
                    <button class="btn btn-danger">Delete</button>
                </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "tag",
    props: {
        tagsObj: {
            type: String,
            default: "{}"
        },
        urlsObj: {
            type: String,
            default: ""
        },
        view: {
            type: String,
            default: ""
        }
    },
    data: function() {
        return {
            tags: JSON.parse(this.tagsObj),
            urls: JSON.parse(this.urlsObj)
        };
    },
    beforeMount: function() {
    },
    mounted() {
        this.$refs.form.innerHTML = this.view
    },
    methods: {
        addTag: function(e){
            let formData = new FormData(e.target)
            axios.post(this.urls.tag, formData, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then((res) => {
                console.log(res.data)
            })
        },
        update: function(index, key, value) {
            this.tags[index][key] = value
        },
        toggleReadonly: function(e, id){
            /*
            const json = axios({
                method: 'POST',
                url: this.url,
                data: {
                    id
                }
            })
            return { ...json.data };
            console.log(this.url)*/
            // console.log(this.getTag(id))
            var input = e.target.closest('tr').querySelector('td input')
            input.toggleAttribute("readonly")

        },
        getTag: function(id){
            return this.tags.find(tag => tag.id === id);
        }
    }
}
</script>

<style>

</style>