// Variables globales
let cart = JSON.parse(localStorage.getItem('cart')) || [];
let cartItemCount = cart.reduce((total, item) => total + item.quantity, 0);

// Sélectionner les éléments du DOM
const cartIcon = document.getElementById('cart-icon');
const cartDropdown = document.getElementById('cart-dropdown');
const cartItemsContainer = document.getElementById('cart-items-container');
const checkoutButton = document.getElementById('checkout-button');
const cartNotification = document.getElementById('cart-notification');
const cartIconContainer = document.querySelector('.cart-icon-container');
const cartCounter = document.getElementById('cart-counter');

// Mettre à jour le compteur du panier au chargement de la page
updateCartCounter();
updateCartDropdown();

// Fonction pour mettre à jour le compteur du panier
function updateCartCounter() {
    cartCounter.textContent = cartItemCount;
}

// Fonction pour mettre à jour le contenu du panier dans le dropdown
function updateCartDropdown() {
    cartItemsContainer.innerHTML = ''; // Vider le contenu du panier
    let totalPrice = 0; // Initialiser le total à 0

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p>Votre panier est vide.</p>';
        checkoutButton.style.display = 'none';
        document.getElementById('cart-total').innerHTML = `<p>Total: CHF 0.00</p>`;
    } else {
        cart.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
                <p>${item.name} - CHF ${item.price.toFixed(2)}</p>
                <div class="cart-quantity">
                    <button class="decrease-quantity" data-index="${index}">-</button>
                    <span class="quantity">${item.quantity}</span>
                    <button class="increase-quantity" data-index="${index}">+</button>
                </div>
                <span class="remove-item" data-index="${index}">Supprimer</span>
            `;
            cartItemsContainer.appendChild(cartItem);

            // Calculer le total pour chaque article (prix * quantité)
            totalPrice += item.price * item.quantity;
        });

        // Afficher le bouton "Passer commande"
        checkoutButton.style.display = 'block';

        // Afficher le total mis à jour
        document.getElementById('cart-total').innerHTML = `<p>Total: CHF ${totalPrice.toFixed(2)}</p>`;
    }

    // Gérer les événements d'augmentation, diminution et suppression
    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', (e) => {
            const index = e.target.getAttribute('data-index');
            cart[index].quantity += 1;
            localStorage.setItem('cart', JSON.stringify(cart));
            cartItemCount++;
            updateCartCounter();
            updateCartDropdown();
        });
    });

    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', (e) => {
            const index = e.target.getAttribute('data-index');
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
                cartItemCount--;
            } else {
                cartItemCount -= cart[index].quantity;
                cart.splice(index, 1);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCounter();
            updateCartDropdown();
        });
    });

    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', (e) => {
            const index = e.target.getAttribute('data-index');
            cartItemCount -= cart[index].quantity;
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCounter();
            updateCartDropdown();
        });
    });
}

// Fonction pour afficher la notification d'ajout au panier
function showCartNotification(productName) {
    cartNotification.textContent = `${productName} a été ajouté au panier !`;
    cartNotification.classList.add('show');
    // Masquer la notification après 2 secondes
    setTimeout(() => {
        cartNotification.classList.remove('show');
    }, 2000);
}

// Gestion des clics sur les boutons "Ajouter au panier"
document.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('btn-ajouter')) {
        const productElement = event.target.closest('.produit');
        const productName = productElement.querySelector('h3').textContent;
        const productPrice = parseFloat(productElement.getAttribute('data-price')) || 0;

        // Vérifier si le produit existe déjà dans le panier
        const existingProduct = cart.find(item => item.name === productName);

        if (existingProduct) {
            // Si le produit existe déjà, augmenter la quantité
            existingProduct.quantity += 1;
        } else {
            // Sinon, ajouter le produit au panier avec une quantité de 1
            cart.push({ name: productName, price: productPrice, quantity: 1 });
        }

        localStorage.setItem('cart', JSON.stringify(cart)); // Enregistrer dans LocalStorage

        cartItemCount++;
        updateCartCounter();
        updateCartDropdown(); // Mettre à jour le contenu du panier

        // Afficher la notification d'ajout au panier
        showCartNotification(productName);
    }
});

// Afficher/cacher le dropdown du panier au clic sur l'icône du panier
cartIcon.addEventListener('click', (event) => {
    event.preventDefault();
    cartIconContainer.classList.toggle('show');
});

// Cacher le dropdown si l'utilisateur clique en dehors du panier
document.addEventListener('click', function(event) {
    if (!cartIconContainer.contains(event.target) && !cartDropdown.contains(event.target) && event.target.id !== 'cart-icon') {
        cartIconContainer.classList.remove('show');
    }
});

// Gestion de la navigation des catégories dans "La Carte"

// Sélectionner tous les liens de la navigation des catégories
const categoryLinks = document.querySelectorAll('.carte-nav ul li a');

// Ajouter un écouteur d'événement sur chaque lien
categoryLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();

        // Récupérer la catégorie sélectionnée
        const category = link.getAttribute('data-category');

        // Mettre à jour la classe active sur la navigation
        document.querySelector('.carte-nav ul li.active').classList.remove('active');
        link.parentElement.classList.add('active');

        // Afficher les produits de la catégorie sélectionnée
        showCategory(category);
    });
});

// Fonction pour afficher les produits de la catégorie sélectionnée
function showCategory(category) {
    // Sélectionner toutes les sections de produits
    const allProductsSections = document.querySelectorAll('.produits');

    // Cacher toutes les sections de produits
    allProductsSections.forEach(section => {
        section.style.display = 'none';
    });

    // Afficher la section correspondant à la catégorie
    document.getElementById(category).style.display = 'flex';
}

// Au chargement de la page, afficher la première catégorie (promotions)
showCategory('promotions');

// Code pour le carousel d'images (si vous l'utilisez toujours)
document.addEventListener('DOMContentLoaded', function() {
    let currentIndex = 0;
    const images = document.querySelectorAll('.carousel-image');
    const dots = document.querySelectorAll('.dot');
    const totalImages = images.length;

    function showSlide(index) {
        if (index >= totalImages) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = totalImages - 1;
        } else {
            currentIndex = index;
        }

        const offset = -currentIndex * 100;
        document.querySelector('.carousel-inner').style.transform = `translateX(${offset}%)`;

        // Mise à jour des points actifs
        dots.forEach((dot, i) => {
            if (i === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function changeSlide(step) {
        showSlide(currentIndex + step);
    }

    function currentSlide(index) {
        showSlide(index - 1);
    }

    // Initialiser le carousel
    showSlide(0);

    // Navigation au clavier
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            changeSlide(-1);
        } else if (e.key === 'ArrowRight') {
            changeSlide(1);
        }
    });

    // Rendre les fonctions accessibles globalement
    window.changeSlide = changeSlide;
    window.currentSlide = currentSlide;
});

// Basculer l'affichage du mot de passe
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('mot_de_passe');

togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('uil-eye');
    this.classList.toggle('uil-eye-slash');
});

// Code postal : Autocomplétion de la localité
$('#code_postal').on('input', function() {
    const codePostal = $(this).val();
    if (codePostal.length === 4) {
        // API simulée pour la démonstration (à remplacer par une API réelle)
        const localites = {
            "1000": "Lausanne",
            "1003": "Lausanne",
            "1012": "Lausanne",
            "1052": "Le Mont-sur-Lausanne"
        };
        if (localites[codePostal]) {
            $('#localite').val(localites[codePostal]);
        } else {
            $('#localite').val('');
        }
    }
});
// Basculer l'affichage du mot de passe
document.querySelectorAll('#togglePassword').forEach(togglePassword => {
    togglePassword.addEventListener('click', function () {
        const passwordField = this.previousElementSibling;
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('uil-eye');
        this.classList.toggle('uil-eye-slash');
    });
});

