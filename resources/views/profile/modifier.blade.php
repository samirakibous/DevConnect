<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kibous Samira - Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    @include('components.navbar')
    <div class="bg-gray-100 text-gray-800 pt-10">

        <div class="container mx-auto p-4 pt-10">

            <div class="bg-white shadow-lg rounded-lg p-6">

                <form action="{{ route('profile.updateModifier') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Utilise PUT ou PATCH pour la mise à jour -->

                    <div class="flex justify-end mt-10">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Valider
                        </button>
                    </div>

                    <label for="profile_picture" class="cursor-pointer">
                        <img src="{{ asset(Auth::user()->profile_picture ?? 'images/placeholder.jpg') }}"
                            id="profileImage" alt="Cliquez pour choisir une photo"
                            class="w-32 h-32 rounded-full mx-auto border-2 border-gray-300 bg-gray-200">
                        <input type="file" id="profile_picture" name="profile_picture" class="hidden"
                            accept="image/*">
                    </label>


                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Informations personnelles</h3>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                            class="mt-2 p-2 border rounded w-full" placeholder="Nom">
                    </div>

                    <!-- Bio -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Bio</h3>
                        <textarea name="bio" class="mt-2 p-2 border rounded w-full" placeholder="Ajouter une biographie">
                            {{ old('bio', Auth::user()->bio) }}</textarea>
                    </div>

                    <!-- Lien GitHub -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Lien GitHub</h3>
                        <input type="url" name="github_link"
                            value="{{ old('github_link', Auth::user()->github_link) }}"
                            class="mt-2 p-2 border rounded w-full" placeholder="https://github.com/ton-profil">
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Description</h3>
                        <textarea name="description" class="mt-2 p-2 border rounded w-full" placeholder="Ajouter une description">{{ old('description', Auth::user()->description) }}</textarea>
                    </div>




                </form>

                <div class="mt-6">
                    <form action="{{ route('certifications.store') }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-semibold">Mes Certifications</h3>
                        <input type="text" id="certifications" class="border p-2 w-full"
                            placeholder="Ajoutez une certification...">
                        <input type="hidden" name="certifications" id="certifications_hidden">
                        <div id="certification-list" class="mt-2 flex flex-wrap gap-2"></div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
                            Enregistrer les certifications
                        </button>
                    </form>
                </div>

                <div class="mt-6">
                    <form action="{{ route('competences.store') }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-semibold">Mes Compétences</h3>
                        <input type="text" id="competences" name="competences[]" class="border p-2 w-full"
                            placeholder="Ajoutez une compétence...">
                        <input type="hidden" name="competences" id="competences_hidden">
                        <div id="competence-list" class="mt-2 flex flex-wrap gap-2"></div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Enregistrer les
                            compétences</button>
                    </form>
                </div>
                <div class="mt-6">
                    <form action="{{ route('add-programming-language.store') }}" method="POST" onsubmit="updateHiddenInput()">
                        @csrf
                        <h3 class="text-lg font-semibold">Langages de programmation</h3>
                        
                        <!-- Input pour entrer un langage -->
                        <input type="text" id="langages" class="border p-2 w-full" placeholder="Ajoutez un langage de programmation...">
                        
                        <!-- Champ caché qui contiendra la liste des langages -->
                        <input type="hidden" name="langages" id="langages_hidden">
                        
                        <!-- Liste des langages affichés -->
                        <div id="langages-list" class="mt-2 flex flex-wrap gap-2"></div>
                        
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
                            Enregistrer les langages
                        </button>
                    </form>
                </div>

                <div class="mt-6">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-semibold">Ajout d'un projet</h3>
                
                        <!-- Input pour entrer le titre du projet -->
                        <input type="text" name="title" class="border p-2 w-full mt-4" placeholder="Titre du projet..." required>
                
                        <!-- Input pour entrer la description du projet -->
                        <textarea name="description" class="border p-2 w-full mt-4" placeholder="Description du projet..." required></textarea>
                
                        <!-- Champ caché pour stocker l'ID de l'utilisateur (si nécessaire) -->
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
                            Ajouter le projet
                        </button>
                    </form>
                </div>
                

            </div>
        </div>
    </div>

    <script>
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader(); // Crée un lecteur de fichier pour afficher l'aperçu
                reader.onload = function(e) {
                    const image = document.getElementById('profileImage');
                    image.src = e.target.result; // Affiche l'image choisie comme prévisualisation
                    image.classList.add(
                        'border-green-500'); // Change la bordure en vert pour indiquer l'image chargée
                };
                reader.readAsDataURL(file); // Lit le fichier comme une URL
            }
        });

        const input = document.getElementById('competences');
        const list = document.getElementById('competence-list');
        let competences = [];
        const competencesHidden = document.getElementById('competences_hidden');

        input.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                let value = input.value.trim();
                if (value !== '' && !competences.includes(value)) {
                    competences.push(value);
                    let span = document.createElement('span');
                    span.className = "bg-blue-500 text-white px-2 py-1 rounded";
                    span.innerHTML = `${value} <button onclick="removeCompetence('${value}')">x</button>`;
                    list.appendChild(span);
                    input.value = '';
                    updateHiddenInput(); // Met à jour l'input caché
                }
            }
        });

        function removeCompetence(comp) {
            competences = competences.filter(c => c !== comp);
            list.innerHTML = competences.map(c =>
                `<span class="bg-blue-500 text-white px-2 py-1 rounded">${c} <button onclick="removeCompetence('${c}')">x</button></span>`
            ).join('');
            updateHiddenInput(); // Met à jour l'input caché
        }

        function updateHiddenInput() {
            // Mettre à jour la valeur de l'input caché avec les compétences sous forme de chaîne
            competencesHidden.value = competences.join(',');
        }


        ///////////////////script pour ajouter plusieurs certifications///////////////////////
        const inputCertif = document.getElementById('certifications');
        const listCertif = document.getElementById('certification-list');
        const certificationsHidden = document.getElementById('certifications_hidden');
        let certifications = [];

        inputCertif.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                let value = inputCertif.value.trim();
                if (value !== '' && !certifications.includes(value)) {
                    certifications.push(value);
                    updateCertificationsList();
                    inputCertif.value = ''; // Réinitialiser le champ après ajout
                }
            }
        });

        function removeCertification(certif) {
            certifications = certifications.filter(c => c !== certif);
            updateCertificationsList();
        }

        function updateCertificationsList() {
            // Mise à jour de l'affichage des certifications
            listCertif.innerHTML = certifications.map(c =>
                `<span class="bg-blue-500 text-white px-2 py-1 rounded flex items-center gap-2">
            ${c} 
            <button type="button" class="text-white font-bold" onclick="removeCertification('${c}')">x</button>
        </span>`
            ).join('');

            // Mettre à jour l'input caché avec les certifications sous forme de chaîne séparée par des virgules
            certificationsHidden.value = certifications.join(','); // Utilisation de join pour séparer par des virgules
        }

        ///////////////////script pour ajouter plusieurs langages de programmations///////////////////////
        const inputLang = document.getElementById('langages');
        const listLang = document.getElementById('langages-list');
        const langagesHidden = document.getElementById('langages_hidden');
        let langages = [];

        inputLang.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                let value = inputLang.value.trim();
                if (value !== '' && !langages.includes(value)) {
                    langages.push(value);
                    updateLangagesList();
                    inputLang.value = ''; // Réinitialiser le champ après ajout
                }
            }
        });

        function removeLangage(lang) {
            langages = langages.filter(l => l !== lang);
            updateLangagesList();
        }

        function updateLangagesList() {
            listLang.innerHTML = langages.map(l =>
                `<span class="bg-blue-500 text-white px-2 py-1 rounded flex items-center gap-2">
            ${l} 
            <button type="button" class="text-white font-bold" onclick="removeLangage('${l}')">x</button>
        </span>`
            ).join('');

            // Mettre à jour l'input caché avec les langages sous forme de chaîne séparée par des virgules
            langagesHidden.value = langages.join(',');
        }
    </script>
</body>

</html>
