<template>
  <div>
    <h2>Mon Questionnaire</h2>
    <form @submit.prevent="addFormulaire" class="mb-3">  
      <div class="form-group">
        <label>Question 1</label>
        <input type="radio" v-model="formulaire.choix" :value="1">One
        <input type="radio" v-model="formulaire.choix" :value="2">Two
        <input type="radio" v-model="formulaire.choix" :value="3">Three
      </div>
      <div class="form-group">
        <label>Question 2</label>
         <input type="checkbox" :value="response1"  v-model="formulaire.response1" >
         <input type="checkbox" :value="response2"  v-model="formulaire.response2" >
         <input type="checkbox" :value="response3"  v-model="formulaire.response3" >
      </div>
      <div class="form-group">
        <label>Question 3</label>
        <textarea class="form-control" placeholder="Contenu" v-model="formulaire.body"></textarea>
      </div>
      <button type="submit" class="btn btn-light btn-block">Valider</button>
    </form>
    <button @click="clearForm()" class="btn btn-danger btn-block">Annuler</button>   
    <div class="card card-body mb-2" v-for="formulaire in formulaires" v-bind:key="formulaire.id">    
      <button @click="editFormulaire(formulaire)" class="btn btn-warning mb-2">Editer</button>
      <button @click="deleteFormulaire(formulaire.id)" class="btn btn-danger">Supprimer</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formulaires: [],
      formulaire: {
        id: '',
        choix: 'choix',checked: false,
        response1: 'response1',checked: false,
        response2: 'response2',checked: false,
        response3: 'response3',checked: false,
        body: ''
      },
      formulaire_id: '',
      edit: false
    };
  },

  created() {
    this.fetchformulaires();
  },

  methods: {
    fetchformulaires(page_url) {
    
      page_url = page_url || '/api/formulaires';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.formulaires = res.data;
       
        })
        .catch(err => console.log(err));
    }, 
    deleteFormulaire(id) {
      if (confirm('Êtes-vous sûr ?')) {
        fetch(`api/formulaire/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('formulaire Removed');
            this.fetchformulaires();
          })
          .catch(err => console.log(err));
      }
    },
    addFormulaire() {
      if (this.edit === false) {
        // Add
        fetch('api/formulaire', {
          method: 'post',
          body: JSON.stringify(this.formulaire),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('formulaire Ajouté');
            this.fetchformulaires();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('api/formulaire', {
          method: 'put',
          body: JSON.stringify(this.formulaire),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('formulaire à jour');
            this.fetchformulaires();
          })
          .catch(err => console.log(err));
      }
    },
    editFormulaire(formulaire) {
      this.edit = true;
      this.formulaire.id = formulaire.id;
      this.formulaire.formulaire_id = formulaire.id;
      this.formulaire.choix = formulaire.choix;
      this.formulaire.response1 = formulaire.response1;
      this.formulaire.response2 = formulaire.response2;
      this.formulaire.response3 = formulaire.response3;
      this.formulaire.body = formulaire.body;
    },
    clearForm() {
      this.edit = false;
      this.formulaire.id = null;
      this.formulaire.formulaire_id = null;
      this.formulaire.choix.checked = false;
      this.formulaire.response1.checked = false;
      this.formulaire.response2.checked = false;
      this.formulaire.response3.checked = false;
      this.formulaire.body = '';
    }
  }
};
</script>
