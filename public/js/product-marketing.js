// LEBOSS TECH - Marketing Enhancement Script
document.addEventListener("DOMContentLoaded", function() {
    initViewerCounter();
    initUrgencyNotifications();
    console.log("í´¥ LEBOSS TECH Marketing Enhancement Loaded");
});

function initViewerCounter() {
    const counter = document.getElementById("viewCounter");
    if (!counter) return;
    
    let currentCount = parseInt(counter.textContent) || 45;
    
    setInterval(() => {
        const change = Math.random() > 0.7 ? 1 : (Math.random() > 0.3 ? 0 : -1);
        currentCount = Math.max(35, Math.min(95, currentCount + change));
        
        counter.style.transform = "scale(1.2)";
        counter.style.color = "#dc2626";
        counter.textContent = currentCount;
        
        setTimeout(() => {
            counter.style.transform = "scale(1)";
            counter.style.color = "#b45309";
        }, 300);
    }, Math.random() * 15000 + 10000);
}

function initUrgencyNotifications() {
    const notifications = [
        "í´¥ Quelqu'un vient d'acheter ce produit",
        "âš¡ 3 personnes ont ce produit dans leur panier",
        "íº¨ Stock limitÃ© - Plus que quelques unitÃ©s",
        "í²° Prix spÃ©cial se termine bientÃ´t"
    ];
    
    setInterval(() => {
        if (Math.random() > 0.7) {
            const message = notifications[Math.floor(Math.random() * notifications.length)];
            showUrgencyNotification(message);
        }
    }, Math.random() * 25000 + 15000);
}

function showUrgencyNotification(message) {
    if (document.querySelector(".urgency-notification")) return;
    
    const notification = document.createElement("div");
    notification.className = "urgency-notification fixed top-20 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50";
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="text-sm font-semibold">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}
