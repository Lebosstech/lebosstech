<!-- WhatsApp Order Modal -->
<div id="whatsappModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                    Commander via WhatsApp
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeWhatsAppModal()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Product Info -->
            <div id="modalProductInfo" class="bg-gray-50 p-3 rounded-lg mb-4">
                <!-- Will be populated by JavaScript -->
            </div>

            <!-- Order Form -->
            <form id="whatsappOrderForm" onsubmit="sendWhatsAppOrder(event)">
                <div class="space-y-4">
                    <!-- Nom complet -->
                    <div>
                        <label for="customerName" class="block text-sm font-medium text-gray-700 mb-1">
                            Nom complet *
                        </label>
                        <input type="text" id="customerName" name="name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-leboss-500 focus:border-leboss-500"
                               placeholder="Votre nom complet">
                    </div>

                    <!-- Contact -->
                    <div>
                        <label for="customerContact" class="block text-sm font-medium text-gray-700 mb-1">
                            Numéro de téléphone *
                        </label>
                        <input type="tel" id="customerContact" name="contact" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-leboss-500 focus:border-leboss-500"
                               placeholder="+225 XX XX XX XX XX">
                    </div>

                    <!-- Lieu de livraison -->
                    <div>
                        <label for="deliveryLocation" class="block text-sm font-medium text-gray-700 mb-1">
                            Lieu de livraison *
                        </label>
                        <select id="deliveryLocation" name="location" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-leboss-500 focus:border-leboss-500">
                            <option value="">Sélectionnez votre zone</option>
                            <option value="Abidjan - Cocody">Abidjan - Cocody</option>
                            <option value="Abidjan - Plateau">Abidjan - Plateau</option>
                            <option value="Abidjan - Marcory">Abidjan - Marcory</option>
                            <option value="Abidjan - Treichville">Abidjan - Treichville</option>
                            <option value="Abidjan - Adjamé">Abidjan - Adjamé</option>
                            <option value="Abidjan - Yopougon">Abidjan - Yopougon</option>
                            <option value="Abidjan - Abobo">Abidjan - Abobo</option>
                            <option value="Abidjan - Koumassi">Abidjan - Koumassi</option>
                            <option value="Abidjan - Port-Bouët">Abidjan - Port-Bouët</option>
                            <option value="Abidjan - Bingerville">Abidjan - Bingerville</option>
                            <option value="Autre - Abidjan">Autre quartier d'Abidjan</option>
                            <option value="Yamoussoukro">Yamoussoukro</option>
                            <option value="Bouaké">Bouaké</option>
                            <option value="San Pedro">San Pedro</option>
                            <option value="Daloa">Daloa</option>
                            <option value="Korhogo">Korhogo</option>
                            <option value="Man">Man</option>
                            <option value="Autre ville">Autre ville de Côte d'Ivoire</option>
                        </select>
                    </div>

                    <!-- Adresse précise -->
                    <div>
                        <label for="exactAddress" class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse précise
                        </label>
                        <textarea id="exactAddress" name="address" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-leboss-500 focus:border-leboss-500"
                                  placeholder="Précisez votre adresse (quartier, rue, point de repère...)"></textarea>
                    </div>

                    <!-- Quantité -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                            Quantité
                        </label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-leboss-500 focus:border-leboss-500">
                    </div>

                    <!-- Message supplémentaire -->
                    <div>
                        <label for="additionalMessage" class="block text-sm font-medium text-gray-700 mb-1">
                            Message supplémentaire (optionnel)
                        </label>
                        <textarea id="additionalMessage" name="message" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-leboss-500 focus:border-leboss-500"
                                  placeholder="Des questions ou précisions particulières ?"></textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex space-x-3 mt-6">
                    <button type="button" onclick="closeWhatsAppModal()" 
                            class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Envoyer commande
                    </button>
                </div>
            </form>

            <!-- Info -->
            <div class="mt-4 p-3 bg-leboss-50 rounded-lg">
                <p class="text-sm text-leboss-700">
                    <i class="fas fa-info-circle mr-1"></i>
                    Votre commande sera envoyée directement à notre équipe via WhatsApp. Nous vous répondrons rapidement !
                </p>
            </div>
        </div>
    </div>
</div>

<script>
let currentProduct = null;

function openWhatsAppModal(product) {
    currentProduct = product;
    
    // Populate product info
    const productInfo = document.getElementById('modalProductInfo');
    productInfo.innerHTML = `
        <div class="flex items-center space-x-3">
            <img src="${product.image || '/images/no-image.jpg'}" alt="${product.name}" class="w-16 h-16 object-cover rounded-lg">
            <div>
                <h4 class="font-semibold text-gray-900">${product.name}</h4>
                <p class="text-leboss-600 font-bold">${product.price} FCFA</p>
                <p class="text-sm text-gray-600">${product.category}</p>
            </div>
        </div>
    `;
    
    document.getElementById('whatsappModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeWhatsAppModal() {
    document.getElementById('whatsappModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Reset form
    document.getElementById('whatsappOrderForm').reset();
    currentProduct = null;
}

function sendWhatsAppOrder(event) {
    event.preventDefault();
    
    if (!currentProduct) return;
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Construire le message WhatsApp
    const customerName = formData.get('name');
    const customerContact = formData.get('contact');
    const deliveryLocation = formData.get('location');
    const exactAddress = formData.get('address');
    const quantity = formData.get('quantity') || 1;
    const additionalMessage = formData.get('message');
    
    let message = `🛒 *NOUVELLE COMMANDE - LEBOSS TECH MARKET*\n\n`;
    message += `📱 *Produit:* ${currentProduct.name}\n`;
    message += `💰 *Prix unitaire:* ${currentProduct.price} FCFA\n`;
    message += `📦 *Quantité:* ${quantity}\n`;
    message += `💵 *Total:* ${(parseFloat(currentProduct.price.replace(/\s/g, '').replace('FCFA', '')) * quantity).toLocaleString()} FCFA\n\n`;
    
    message += `👤 *INFORMATIONS CLIENT:*\n`;
    message += `• Nom: ${customerName}\n`;
    message += `• Contact: ${customerContact}\n`;
    message += `• Zone de livraison: ${deliveryLocation}\n`;
    
    if (exactAddress) {
        message += `• Adresse précise: ${exactAddress}\n`;
    }
    
    if (additionalMessage) {
        message += `\n💬 *Message:* ${additionalMessage}\n`;
    }
    
    message += `\n⏰ Commande passée le ${new Date().toLocaleString('fr-FR')}\n`;
    message += `\n🔗 Lien produit: ${window.location.origin}/produits/${currentProduct.slug}`;
    
    // Encoder le message pour l'URL
    const encodedMessage = encodeURIComponent(message);
    
    // Construire l'URL WhatsApp
    const whatsappUrl = `https://wa.me/2250566821609?text=${encodedMessage}`;
    
    // Enregistrer le clic WhatsApp
    if (currentProduct.clickTrackUrl) {
        fetch(currentProduct.clickTrackUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    }
    
    // Ouvrir WhatsApp
    window.open(whatsappUrl, '_blank');
    
    // Fermer le modal
    closeWhatsAppModal();
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('whatsappModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeWhatsAppModal();
    }
});

// Fermer le modal avec la touche Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeWhatsAppModal();
    }
});
</script> 