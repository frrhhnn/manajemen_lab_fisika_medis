/**
 * Admin Dashboard JavaScript
 * Corporate-level functionality and interactions
 */

class AdminDashboard {
    constructor() {
        this.currentTab = 'dashboard';
        this.sidebar = document.getElementById('sidebar');
        this.sidebarToggle = document.getElementById('sidebarToggle');
        this.sidebarOverlay = document.getElementById('sidebarOverlay');
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupTabNavigation();
        this.setupModals();
        this.setupDataTables();
        this.setupFormValidation();
        this.loadInitialData();
    }

    setupEventListeners() {
        // Sidebar toggle
        if (this.sidebarToggle) {
            this.sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Sidebar overlay
        if (this.sidebarOverlay) {
            this.sidebarOverlay.addEventListener('click', () => this.closeSidebar());
        }

        // Escape key to close modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });

        // Window resize handler
        window.addEventListener('resize', () => this.handleResize());
    }

    setupTabNavigation() {
        const navLinks = document.querySelectorAll('[data-tab]');
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const tabName = link.getAttribute('data-tab');
                this.showTab(tabName);
            });
        });
    }

    showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });

        // Show selected tab
        const targetTab = document.getElementById(`${tabName}-tab`);
        if (targetTab) {
            targetTab.style.display = 'block';
        }

        // Update navigation
        document.querySelectorAll('.nav-item').forEach(nav => {
            nav.classList.remove('active');
        });

        const activeNav = document.querySelector(`[data-tab="${tabName}"]`);
        if (activeNav) {
            activeNav.classList.add('active');
        }

        // Update page title
        const titles = {
            'dashboard': 'Dashboard',
            'equipment': 'Inventaris Alat',
            'rentals': 'Kelola Peminjaman Alat',
            'visits': 'Kunjungan',
            'staff': 'Kelola Staff',
            'vision-mission': 'Kelola Visi & Misi',
        };

        const pageTitle = document.getElementById('pageTitle');
        if (pageTitle && titles[tabName]) {
            pageTitle.textContent = titles[tabName];
        }

        this.currentTab = tabName;
        this.loadTabData(tabName);
    }

    loadTabData(tabName) {
        switch (tabName) {
            case 'equipment':
                this.loadEquipmentData();
                break;
            case 'rentals':
                this.loadRentalsData();
                break;
            case 'visits':
                this.loadVisitData();
                break;
            case 'staff':
                // Staff tab is handled by Alpine.js
                break;
            case 'vision-mission':
                // Vision mission tab is handled by its own JavaScript
                break;
            default:
                this.loadDashboardData();
        }
    }

    async loadRentalsData() {
        try {
            // Ensure rental functions are available and initialize tab-specific handlers
            if (typeof window.tabSwitchHandlers !== 'undefined' && 
                typeof window.tabSwitchHandlers.rentals === 'function') {
                setTimeout(() => {
                    window.tabSwitchHandlers.rentals();
                }, 100);
            }
            
            console.log('Rentals tab loaded - checking function availability');
            
            // Verify rental functions are available
            const requiredFunctions = [
                'viewRentalDetail', 
                'approveRental', 
                'rejectRental', 
                'confirmRental', 
                'completeRental'
            ];
            
            requiredFunctions.forEach(funcName => {
                if (typeof window[funcName] === 'function') {
                    console.log('✅ Function available:', funcName);
                } else {
                    console.warn('❌ Function missing:', funcName);
                }
            });
            
        } catch (error) {
            console.error('Error loading peminjaman alat data:', error);
        }
    }

    toggleSidebar() {
        this.sidebar.classList.toggle('open');
        if (this.sidebarOverlay) {
            this.sidebarOverlay.style.display = this.sidebar.classList.contains('open') ? 'block' : 'none';
        }
    }

    closeSidebar() {
        this.sidebar.classList.remove('open');
        if (this.sidebarOverlay) {
            this.sidebarOverlay.style.display = 'none';
        }
    }

    handleResize() {
        if (window.innerWidth >= 1024) {
            this.closeSidebar();
        }
    }

    setupModals() {
        // Modal open buttons
        document.querySelectorAll('[data-modal]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = btn.getAttribute('data-modal');
                this.openModal(modalId);
            });
        });

        // Modal close buttons
        document.querySelectorAll('.modal-close').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const modal = btn.closest('.modal-overlay');
                if (modal) {
                    this.closeModal(modal.id);
                }
            });
        });

        // Modal overlay clicks
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    this.closeModal(overlay.id);
                }
            });
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Focus management
            const firstInput = modal.querySelector('input, select, textarea, button');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    closeAllModals() {
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.style.display = 'none';
        });
        document.body.style.overflow = 'auto';
    }

    setupDataTables() {
        // Setup sortable tables
        document.querySelectorAll('.table').forEach(table => {
            this.makeTableSortable(table);
        });

        // Setup pagination
        document.querySelectorAll('.pagination').forEach(pagination => {
            this.setupPagination(pagination);
        });
    }

    makeTableSortable(table) {
        const headers = table.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                const column = header.getAttribute('data-sort');
                this.sortTable(table, column);
            });
        });
    }

    sortTable(table, column) {
        // Implementation for table sorting
        console.log('Sorting table by:', column);
    }

    setupPagination(pagination) {
        const buttons = pagination.querySelectorAll('button[data-page]');
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const page = button.getAttribute('data-page');
                this.loadPage(page);
            });
        });
    }

    setupFormValidation() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });

            // Real-time validation
            form.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('blur', () => this.validateField(field));
                field.addEventListener('input', () => this.clearFieldError(field));
            });
        });
    }

    validateForm(form) {
        let isValid = true;
        const fields = form.querySelectorAll('input[required], select[required], textarea[required]');
        
        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const fieldType = field.type;

        this.clearFieldError(field);

        if (isRequired && !value) {
            this.showFieldError(field, 'This field is required');
            return false;
        }

        if (value && fieldType === 'email' && !this.isValidEmail(value)) {
            this.showFieldError(field, 'Please enter a valid email address');
            return false;
        }

        if (value && fieldType === 'tel' && !this.isValidPhone(value)) {
            this.showFieldError(field, 'Please enter a valid phone number');
            return false;
        }

        return true;
    }

    showFieldError(field, message) {
        field.classList.add('error');
        
        let errorDiv = field.parentNode.querySelector('.field-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'field-error';
            field.parentNode.appendChild(errorDiv);
        }
        
        errorDiv.textContent = message;
        errorDiv.style.color = 'var(--danger-600)';
        errorDiv.style.fontSize = 'var(--font-size-xs)';
        errorDiv.style.marginTop = 'var(--spacing-1)';
    }

    clearFieldError(field) {
        field.classList.remove('error');
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    isValidPhone(phone) {
        return /^[\+]?[1-9][\d]{0,15}$/.test(phone.replace(/\s/g, ''));
    }

    // Data loading methods
    loadInitialData() {
        this.loadDashboardData();
        this.updateNotificationCount();
    }

    async loadDashboardData() {
        try {
            // This would typically fetch from API
            const stats = await this.fetchStats();
            this.updateStatsCards(stats);
            
            const activities = await this.fetchRecentActivities();
            this.updateActivityFeed(activities);
        } catch (error) {
            console.error('Error loading dashboard data:', error);
            this.showNotification('Error loading dashboard data', 'error');
        }
    }

    async loadEquipmentData() {
        try {
            const equipment = await this.fetchEquipment();
            this.updateEquipmentTable(equipment);
        } catch (error) {
            console.error('Error loading equipment data:', error);
        }
    }

    async loadRentalData() {
        try {
            const rentals = await this.fetchRentals();
            this.updateRentalTable(rentals);
        } catch (error) {
            console.error('Error loading rental data:', error);
        }
    }

    async loadVisitData() {
        try {
            const visits = await this.fetchVisits();
            this.updateVisitTable(visits);
        } catch (error) {
            console.error('Error loading visit data:', error);
        }
    }

    // API simulation methods (replace with actual API calls)
    async fetchStats() {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve({
                    totalEquipment: 42,
                    availableEquipment: 38,
                    pendingRequests: 7,
                    urgentItems: 3
                });
            }, 500);
        });
    }

    async fetchRecentActivities() {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve([
                    {
                        type: 'rental',
                        title: 'New rental request',
                        description: 'Geiger Counter - Dr. Ahmad',
                        time: '2h ago',
                        icon: 'handshake'
                    },
                    {
                        type: 'visit',
                        title: 'Visit scheduled',
                        description: 'University Research Team',
                        time: '4h ago',
                        icon: 'users'
                    },
                    {
                        type: 'test',
                        title: 'Test completed',
                        description: 'Radioactivity measurement',
                        time: '6h ago',
                        icon: 'flask'
                    }
                ]);
            }, 300);
        });
    }

    async fetchEquipment() {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve([
                    {
                        id: 1,
                        code: 'GM-001',
                        name: 'Geiger-Müller Counter',
                        category: 'Radiation Detection',
                        status: 'available',
                        condition: 'excellent',
                        location: 'Room A101'
                    }
                ]);
            }, 500);
        });
    }

    // UI update methods
    updateStatsCards(stats) {
        const elements = {
            totalEquipment: document.getElementById('totalEquipment'),
            availableEquipment: document.getElementById('availableEquipment'),
            pendingRequests: document.getElementById('pendingRequests'),
            urgentItems: document.getElementById('urgentItems')
        };

        // Only update elements that exist
        if (elements.totalEquipment) elements.totalEquipment.textContent = stats.totalEquipment;
        if (elements.availableEquipment) elements.availableEquipment.textContent = stats.availableEquipment;
        if (elements.pendingRequests) elements.pendingRequests.textContent = stats.pendingRequests;
        if (elements.urgentItems) elements.urgentItems.textContent = stats.urgentItems;
    }

    updateActivityFeed(activities) {
        const container = document.getElementById('activityFeed');
        if (!container) return;

        container.innerHTML = activities.map(activity => `
            <div class="activity-item">
                <div class="activity-icon ${activity.type}">
                    <i class="fas fa-${activity.icon}"></i>
                </div>
                <div class="activity-content">
                    <h4>${activity.title}</h4>
                    <p>${activity.description}</p>
                </div>
                <span class="activity-time">${activity.time}</span>
            </div>
        `).join('');
    }

    updateNotificationCount() {
        const badge = document.getElementById('notificationBadge');
        if (badge) {
            // This would typically come from API
            const count = 3;
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Add to container
        let container = document.getElementById('notificationContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notificationContainer';
            container.className = 'notification-container';
            document.body.appendChild(container);
        }

        container.appendChild(notification);

        // Auto remove
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);

        // Manual close
        notification.querySelector('.notification-close').addEventListener('click', () => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        });
    }

    getNotificationIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    // Utility methods
    formatDate(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Commented out to prevent conflict with Alpine.js
    // window.adminDashboard = new AdminDashboard();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AdminDashboard;
}

// Alpine.js Data
document.addEventListener('alpine:init', () => {
    Alpine.data('dashboard', () => ({
        currentTab: 'dashboard',
        sidebarOpen: false,
        showModal: false,
        modalTitle: '',
        modalContent: '',
        showNotifications: false,
        notifications: [],

        init() {
            // Initialize dashboard
            this.loadNotifications();
            this.setupEventListeners();
        },

        // Tab Management
        switchTab(tabName) {
            this.currentTab = tabName;
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            document.getElementById(`nav-${tabName}`).classList.add('active');
            
            // Update page title
            const titles = {
                dashboard: 'Dashboard',
                equipment: 'Inventaris Alat',
                rentals: 'Equipment Rental Management',
                visits: 'Kunjungan',
                staff: 'Staff',
                visionMission: 'Visi & Misi'
            };
            document.getElementById('page-title').textContent = titles[tabName];
        },

        // Modal Management
        openModal(title, content) {
            this.modalTitle = title;
            this.modalContent = content;
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
            this.modalTitle = '';
            this.modalContent = '';
        },

        // Notification Management
        loadNotifications() {
            // Example notifications - replace with actual API call
            this.notifications = [
                {
                    id: 1,
                    type: 'rental',
                    message: 'Permintaan penyewaan baru: Geiger Counter',
                    time: '2 menit yang lalu',
                    read: false
                },
                {
                    id: 2,
                    type: 'visit',
                    message: 'Kunjungan baru dijadwalkan',
                    time: '1 jam yang lalu',
                    read: false
                }
            ];
        },

        toggleNotifications() {
            this.showNotifications = !this.showNotifications;
        },

        markNotificationAsRead(id) {
            this.notifications = this.notifications.map(notif => {
                if (notif.id === id) {
                    return { ...notif, read: true };
                }
                return notif;
            });
        },

        // Event Listeners
        setupEventListeners() {
            // Handle responsive sidebar
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    this.sidebarOpen = false;
                }
            });

            // Handle escape key for modal
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeModal();
                    this.showNotifications = false;
                }
            });
        },

        // Data Table Management
        sortTable(column) {
            // Implement table sorting logic
        },

        filterTable(query) {
            // Implement table filtering logic
        },

        // Form Management
        async submitForm(formData) {
            try {
                // Example form submission
                const response = await fetch('/api/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                this.openModal('Success', 'Data has been saved successfully!');
            } catch (error) {
                console.error('Error:', error);
                this.openModal('Error', 'An error occurred while saving the data.');
            }
        },

        // File Upload Management
        async handleFileUpload(files) {
            const formData = new FormData();
            for (let file of files) {
                formData.append('files[]', file);
            }

            try {
                const response = await fetch('/api/upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                this.openModal('Success', 'Files have been uploaded successfully!');
            } catch (error) {
                console.error('Error:', error);
                this.openModal('Error', 'An error occurred while uploading the files.');
            }
        }
    }));
});

// Custom Event Handlers
document.addEventListener('DOMContentLoaded', () => {
    // Handle file drag and drop
    const dropZones = document.querySelectorAll('.drop-zone');
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.classList.add('border-blue-500');
        });

        zone.addEventListener('dragleave', () => {
            zone.classList.remove('border-blue-500');
        });

        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('border-blue-500');
            const files = e.dataTransfer.files;
            // Trigger Alpine.js file upload handler
            zone.__x.$data.handleFileUpload(files);
        });
    });

    // Initialize any third-party plugins
    // Example: Initialize date pickers, rich text editors, etc.
});

// Toggle sidebar on mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    
    if (window.innerWidth < 1024 && 
        !sidebar.contains(event.target) && 
        !mobileMenuBtn.contains(event.target)) {
        sidebar.classList.remove('open');
    }
});

// Modal functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking overlay
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const openModal = document.querySelector('.modal-overlay:not(.hidden)');
        if (openModal) {
            openModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }
});

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('error');
            isValid = false;
        } else {
            field.classList.remove('error');
        }
    });
    
    return isValid;
}

// Show success message
function showSuccessMessage(message) {
    // You can implement a toast notification here
    alert(message);
}

// Show error message
function showErrorMessage(message) {
    // You can implement a toast notification here
    alert('Error: ' + message);
}

// Confirm action
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
}

// Initialize tooltips
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.getAttribute('title');
            tooltip.style.position = 'absolute';
            tooltip.style.backgroundColor = '#333';
            tooltip.style.color = 'white';
            tooltip.style.padding = '5px 10px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.fontSize = '12px';
            tooltip.style.zIndex = '1000';
            tooltip.style.pointerEvents = 'none';
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            
            this._tooltip = tooltip;
        });
        
        element.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                this._tooltip = null;
            }
        });
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initTooltips();
    
    // Add loading states to buttons
    const buttons = document.querySelectorAll('button[type="submit"]');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && !validateForm(this.form.id)) {
                return;
            }
            
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            
            // Re-enable after form submission (you might want to handle this differently)
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = this.getAttribute('data-original-text') || 'Submit';
            }, 3000);
        });
    });
});

// Export functions for global use
window.AdminDashboard = {
    toggleSidebar,
    showModal,
    hideModal,
    validateForm,
    showSuccessMessage,
    showErrorMessage,
    confirmAction,
    formatDate,
    formatCurrency
}; 