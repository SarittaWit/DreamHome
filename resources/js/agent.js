// Confirmer une visite
function confirmVisit(id) {
    axios.post(`/visits/${id}/status`, { status: 'confirmed' })
        .then(response => {
            window.location.reload();
        })
        .catch(error => {
            alert('Erreur lors de la confirmation');
        });
}

// Afficher les détails d'une visite
function showVisitDetails(id) {
    axios.get(`/visits/${id}`)
        .then(response => {
            const visit = response.data.visit;
            // Remplir le modal avec les données
            document.getElementById('visitProperty').textContent =
                `${visit.property.title} - ${visit.property.location}`;
            // ... autres champs ...

            // Afficher le modal
            openModal('visitDetailsModal');
        })
        .catch(error => {
            alert('Erreur lors du chargement des détails');
        });
}
