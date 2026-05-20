<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookAPI | Premium Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-dark: #0f172a;
            --glass: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15), transparent),
                              radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15), transparent);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Glassmorphism Utility */
        .glass {
            background: var(--glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
        }

        /* Auth Screen */
        #auth-screen {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            padding: 3rem;
            animation: fadeIn 0.5s ease-out;
        }

        .auth-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .auth-tab {
            flex: 1;
            padding: 0.75rem;
            text-align: center;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            color: var(--text-dim);
            transition: 0.3s;
        }

        .auth-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            font-weight: 600;
        }

        /* Dashboard Screen */
        #dashboard-screen {
            display: none;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .book-card {
            padding: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .book-card h3 {
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        .book-card .author {
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .book-card .desc {
            color: var(--text-dim);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .book-card .year {
            font-size: 0.8rem;
            background: rgba(99, 102, 241, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            color: var(--primary);
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-dim);
        }

        input, textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
        }

        button {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.85rem;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: var(--primary-hover);
            transform: scale(1.02);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--glass-border);
            padding: 0.5rem 1rem;
            width: auto;
        }

        .btn-outline:hover {
            background: var(--glass);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            width: auto;
            padding: 0.5rem;
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Notification */
        #notification {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 2rem;
            border-radius: 1rem;
            display: none;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div id="notification" class="glass"></div>

    <div class="container">
        <!-- Auth Screen -->
        <div id="auth-screen">
            <div class="auth-card glass">
                <div class="logo" style="justify-content: center; margin-bottom: 2rem;">
                    <i data-lucide="book-open"></i> BookAPI
                </div>
                <div class="auth-tabs">
                    <div class="auth-tab active" onclick="switchAuth('login')">Login</div>
                    <div class="auth-tab" onclick="switchAuth('register')">Register</div>
                </div>

                <form id="login-form">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="login-email" placeholder="pete@abc.com" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="login-password" placeholder="••••••••" required>
                    </div>
                    <button type="submit">Enter Dashboard</button>
                </form>

                <form id="register-form" style="display: none;">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="reg-name" placeholder="Peter Parker" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="reg-email" placeholder="peter@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="reg-password" placeholder="Min 8 chars" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" id="reg-password-confirm" placeholder="Repeat password" required>
                    </div>
                    <button type="submit">Create Account</button>
                </form>
            </div>
        </div>

        <!-- Dashboard Screen -->
        <div id="dashboard-screen">
            <header>
                <div class="logo">
                    <i data-lucide="book-open"></i> BookAPI
                </div>
                <div class="user-info">
                    <span id="welcome-text"></span>
                    <button class="btn-outline" onclick="logout()">
                        <i data-lucide="log-out" style="width: 16px; display: inline; vertical-align: middle;"></i> Logout
                    </button>
                </div>
            </header>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2>My Book Collection</h2>
                <button class="btn-outline" style="background: var(--primary); border: none;" onclick="showAddModal()">
                    + Add New Book
                </button>
            </div>

            <div id="books-list" class="books-grid">
                <!-- Books will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div id="add-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 100; align-items: center; justify-content: center;">
        <div class="glass" style="width: 100%; max-width: 500px; padding: 3rem;">
            <h2 style="margin-bottom: 2rem;">Add New Book</h2>
            <form id="add-book-form">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" id="book-title" required>
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" id="book-author" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="book-desc" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Published Year</label>
                    <input type="number" id="book-year" required>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="button" class="btn-outline" onclick="closeAddModal()" style="flex: 1;">Cancel</button>
                    <button type="submit" style="flex: 1;">Save Book</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize icons
        lucide.createIcons();

        // Check if user is already logged in by looking at localStorage
        let token = localStorage.getItem('api_token');
        let user = JSON.parse(localStorage.getItem('user'));

        if (token) {
            showDashboard();
        }

        /**
         * Switch between Login and Register forms
         */
        function switchAuth(type) {
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');
            
            if (type === 'login') {
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'none';
            } else {
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'block';
            }
        }

        /**
         * Hide auth screen and show the book collection dashboard
         */
        function showDashboard() {
            document.getElementById('auth-screen').style.display = 'none';
            document.getElementById('dashboard-screen').style.display = 'block';
            document.getElementById('welcome-text').innerText = `Welcome, ${user.name}`;
            loadBooks(); // Immediately fetch books from API
        }

        /**
         * Show a floating notification at the bottom
         */
        function notify(msg, type = 'success') {
            const n = document.getElementById('notification');
            n.innerText = msg;
            n.style.display = 'block';
            n.style.borderColor = type === 'success' ? 'var(--primary)' : '#ef4444';
            setTimeout(() => n.style.display = 'none', 3000);
        }

        // --- API Interactions ---

        /**
         * LOGIN REQUEST
         * Sends email/password to /api/login and saves the returned token
         */
        document.getElementById('login-form').onsubmit = async (e) => {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const data = await res.json();
                
                if (res.ok) {
                    // Save credentials locally so the user stays logged in
                    localStorage.setItem('api_token', data.token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                    token = data.token;
                    user = data.user;
                    showDashboard();
                    notify('Logged in successfully!');
                } else {
                    notify(data.message || 'Login failed', 'error');
                }
            } catch (err) {
                notify('Connection error', 'error');
            }
        };

        /**
         * FETCH ALL BOOKS
         * Calls GET /api/books with the Bearer token in the header
         */
        async function loadBooks() {
            const res = await fetch('/api/books', {
                headers: { 
                    'Authorization': `Bearer ${token}`, // Identify who is asking
                    'Accept': 'application/json' 
                }
            });
            const { data } = await res.json();
            
            const list = document.getElementById('books-list');
            list.innerHTML = data.map(book => `
                <div class="book-card glass">
                    <button class="btn-delete glass" onclick="deleteBook(${book.id})">
                        <i data-lucide="trash-2" style="width: 16px;"></i>
                    </button>
                    <h3>${book.title}</h3>
                    <div class="author">by ${book.author}</div>
                    <p class="desc">${book.description}</p>
                    <span class="year">${book.published_year}</span>
                </div>
            `).join('');
            lucide.createIcons();
        }
        
        /**
         * DELETE BOOK
         * Calls DELETE /api/books/{id}
         */
        async function deleteBook(id) {
            if (!confirm('Delete this book?')) return;
            const res = await fetch(`/api/books/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            if (res.ok) {
                notify('Book deleted');
                loadBooks(); // Refresh the list
            }
        }

        /**
         * Open the Add Book modal
         */
        function showAddModal() { 
            document.getElementById('add-modal').style.display = 'flex'; 
        }

        /**
         * Close the Add Book modal
         */
        function closeAddModal() { 
            document.getElementById('add-modal').style.display = 'none'; 
        }

        /**
         * REGISTER REQUEST
         * Sends details to /api/register and logs the user in
         */
        document.getElementById('register-form').onsubmit = async (e) => {
            e.preventDefault();
            const name = document.getElementById('reg-name').value;
            const email = document.getElementById('reg-email').value;
            const password = document.getElementById('reg-password').value;
            const password_confirmation = document.getElementById('reg-password-confirm').value;

            try {
                const res = await fetch('/api/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ name, email, password, password_confirmation })
                });
                const data = await res.json();
                
                if (res.ok) {
                    localStorage.setItem('api_token', data.token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                    token = data.token;
                    user = data.user;
                    showDashboard();
                    notify('Account created!');
                } else {
                    notify(data.message || 'Registration failed', 'error');
                }
            } catch (err) {
                notify('Connection error', 'error');
            }
        };

        /**
         * ADD BOOK
         * Calls POST /api/books with book details
         */
        document.getElementById('add-book-form').onsubmit = async (e) => {
            e.preventDefault();
            const book = {
                title: document.getElementById('book-title').value,
                author: document.getElementById('book-author').value,
                description: document.getElementById('book-desc').value,
                published_year: parseInt(document.getElementById('book-year').value)
            };

            const res = await fetch('/api/books', {
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${token}`, 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json' 
                },
                body: JSON.stringify(book)
            });

            if (res.ok) {
                closeAddModal();
                loadBooks();
                notify('Book added to collection!');
                e.target.reset();
            } else {
                const data = await res.json();
                notify(data.message || 'Failed to add book', 'error');
            }
        };

        /**
         * LOGOUT
         * Calls /api/logout and clears local storage
         */
        async function logout() {
            await fetch('/api/logout', {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            localStorage.clear();
            location.reload();
        }
    </script>
</body>
</html>
