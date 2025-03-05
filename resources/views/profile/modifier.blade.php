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

                    <!-- certification -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Certification</h3>
                        <textarea id="certification" name="certification">{{ old('certification', Auth::user()->certifications) }}</textarea>
                    </div>


                    <!-- Description -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Description</h3>
                        <textarea name="description" class="mt-2 p-2 border rounded w-full" placeholder="Ajouter une description">{{ old('description', Auth::user()->description) }}</textarea>
                    </div>




                </form>


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
    </script>
</body>

</html>
