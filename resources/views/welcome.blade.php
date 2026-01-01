<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IqbalDev API Service - Modern & Powerful</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 40px rgba(147, 51, 234, 0.8); }
        }
        
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .float { animation: float 4s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-x 8s ease infinite;
        }
        .slide-up { animation: slide-up 0.8s ease-out; }
        .spin-slow { animation: spin-slow 20s linear infinite; }
        
        .glass {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gradient-border {
            position: relative;
            background: linear-gradient(145deg, #1f2937, #111827);
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 2px;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
        
        .dot-pattern {
            background-image: radial-gradient(circle, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-950 text-white overflow-x-hidden">
    <!-- Background Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-700"></div>
        <div class="absolute bottom-1/4 left-1/2 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-1000"></div>
    </div>

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center font-bold text-xl spin-slow">
                        I
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 bg-clip-text text-transparent gradient-animate">
                        IqbalDev API
                    </span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="hover:text-blue-400 transition-all duration-300 relative group">
                        Features
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#endpoints" class="hover:text-purple-400 transition-all duration-300 relative group">
                        API Docs
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-purple-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#pricing" class="hover:text-pink-400 transition-all duration-300 relative group">
                        Pricing
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-pink-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#contact" class="hover:text-green-400 transition-all duration-300 relative group">
                        Contact
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>
                <a href="#contact" class="bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 px-6 py-2.5 rounded-xl font-semibold hover:scale-105 transition-all duration-300 pulse-glow">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 px-4 dot-pattern">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16 slide-up">
                <div class="inline-block mb-6">
                    <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-semibold animate-pulse">
                        🚀 Now Live & Ready to Use
                    </span>
                </div>
                <h1 class="text-6xl md:text-8xl font-bold mb-8 leading-tight">
                    Build with the
                    <br/>
                    <span class="bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 bg-clip-text text-transparent gradient-animate">
                        Future of APIs
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-400 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Lightning-fast, secure, and incredibly simple API service designed for modern developers. 
                    Scale your applications with confidence.
                </p>
                <div class="flex flex-wrap justify-center gap-6 mb-16">
                    <a href="#contact" class="group bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 px-10 py-5 rounded-2xl font-bold text-lg hover:scale-105 transition-all duration-300 pulse-glow">
                        Start Building Now
                        <span class="inline-block ml-2 group-hover:translate-x-2 transition-transform">→</span>
                    </a>
                    <a href="#endpoints" class="glass px-10 py-5 rounded-2xl font-bold text-lg hover:border-blue-500 transition-all duration-300 border-2 border-transparent">
                        Explore API Docs
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <div class="glass p-6 rounded-2xl hover:scale-105 transition-all duration-300">
                        <div class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent mb-2">99.9%</div>
                        <div class="text-gray-400 text-sm">Uptime SLA</div>
                    </div>
                    <div class="glass p-6 rounded-2xl hover:scale-105 transition-all duration-300">
                        <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-purple-600 bg-clip-text text-transparent mb-2">&lt;50ms</div>
                        <div class="text-gray-400 text-sm">Response Time</div>
                    </div>
                    <div class="glass p-6 rounded-2xl hover:scale-105 transition-all duration-300">
                        <div class="text-4xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent mb-2">15k+</div>
                        <div class="text-gray-400 text-sm">Req/Second</div>
                    </div>
                    <div class="glass p-6 rounded-2xl hover:scale-105 transition-all duration-300">
                        <div class="text-4xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent mb-2">24/7</div>
                        <div class="text-gray-400 text-sm">Support</div>
                    </div>
                </div>
            </div>

            <!-- Code Preview -->
            <div class="max-w-4xl mx-auto float">
                <div class="gradient-border rounded-2xl p-1">
                    <div class="bg-gray-900 rounded-2xl p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="ml-4 text-gray-500 text-sm">Terminal</span>
                        </div>
                        <pre class="text-sm md:text-base text-green-400 overflow-x-auto"><code><span class="text-purple-400">$</span> curl -X GET https://service.iqbaldev.site/api/v1/data \
  <span class="text-blue-400">-H</span> <span class="text-yellow-400">"Authorization: Bearer YOUR_API_KEY"</span> \
  <span class="text-blue-400">-H</span> <span class="text-yellow-400">"Content-Type: application/json"</span>

<span class="text-gray-400">{</span>
  <span class="text-blue-300">"status"</span>: <span class="text-yellow-400">"success"</span>,
  <span class="text-blue-300">"data"</span>: <span class="text-gray-400">{</span>
    <span class="text-blue-300">"message"</span>: <span class="text-yellow-400">"Welcome to IqbalDev API ⚡"</span>,
    <span class="text-blue-300">"version"</span>: <span class="text-yellow-400">"2.0.0"</span>,
    <span class="text-blue-300">"performance"</span>: <span class="text-yellow-400">"optimized"</span>
  <span class="text-gray-400">}</span>
<span class="text-gray-400">}</span></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 px-4 relative">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-bold mb-6">
                    Powerful <span class="bg-gradient-to-r from-blue-400 to-purple-600 bg-clip-text text-transparent">Features</span>
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Everything you need to build world-class applications with confidence
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 cursor-pointer">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">⚡</div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">
                        Lightning Fast
                    </h3>
                    <p class="text-gray-400 leading-relaxed">
                        Optimized infrastructure delivering sub-50ms response times globally with edge caching
                    </p>
                </div>
                
                <div class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 cursor-pointer">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">🔒</div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-purple-400 to-purple-600 bg-clip-text text-transparent">
                        Ultra Secure
                    </h3>
                    <p class="text-gray-400 leading-relaxed">
                        Enterprise-grade security with JWT authentication, rate limiting, and DDoS protection
                    </p>
                </div>
                
                <div class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 cursor-pointer">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">📊</div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">
                        Real-time Analytics
                    </h3>
                    <p class="text-gray-400 leading-relaxed">
                        Comprehensive dashboard with live metrics, usage tracking, and performance insights
                    </p>
                </div>
                
                <div class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 cursor-pointer">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">🌍</div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">
                        Global CDN
                    </h3>
                    <p class="text-gray-400 leading-relaxed">
                        Distributed across multiple regions for minimal latency and maximum availability
                    </p>
                </div>
                
                <div class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 cursor-pointer">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">📝</div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-yellow-400 to-orange-600 bg-clip-text text-transparent">
                        Complete Docs
                    </h3>
                    <p class="text-gray-400 leading-relaxed">
                        Clear documentation with interactive examples in multiple programming languages
                    </p>
                </div>
                
                <div class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 cursor-pointer">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">🚀</div>
                    <h3 class="text-2xl font-bold mb-4 bg-gradient-to-r from-cyan-400 to-blue-600 bg-clip-text text-transparent">
                        Auto Scaling
                    </h3>
                    <p class="text-gray-400 leading-relaxed">
                        Automatically scales to handle traffic spikes without any configuration needed
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- API Endpoints -->
    <section id="endpoints" class="py-24 px-4 relative">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-bold mb-6">
                    RESTful <span class="bg-gradient-to-r from-purple-400 to-pink-600 bg-clip-text text-transparent">Endpoints</span>
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Simple, intuitive, and powerful API design following industry best practices
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 max-w-5xl mx-auto">
                <div class="glass p-6 rounded-2xl hover:border-green-500 border-2 border-transparent transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="bg-green-500/20 text-green-400 px-4 py-2 rounded-lg text-sm font-bold border border-green-500/50">
                            GET
                        </span>
                        <code class="text-blue-400 font-mono text-lg">/api/v1/users</code>
                    </div>
                    <p class="text-gray-400">Retrieve all users with pagination, filtering, and sorting support</p>
                    <div class="mt-4 text-xs text-gray-500 font-mono bg-gray-900/50 p-3 rounded-lg">
                        ?page=1&limit=10&sort=created_at
                    </div>
                </div>
                
                <div class="glass p-6 rounded-2xl hover:border-blue-500 border-2 border-transparent transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="bg-blue-500/20 text-blue-400 px-4 py-2 rounded-lg text-sm font-bold border border-blue-500/50">
                            POST
                        </span>
                        <code class="text-blue-400 font-mono text-lg">/api/v1/users</code>
                    </div>
                    <p class="text-gray-400">Create new user with automatic validation and error handling</p>
                    <div class="mt-4 text-xs text-gray-500 font-mono bg-gray-900/50 p-3 rounded-lg">
                        Body: { name, email, password }
                    </div>
                </div>
                
                <div class="glass p-6 rounded-2xl hover:border-yellow-500 border-2 border-transparent transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-lg text-sm font-bold border border-yellow-500/50">
                            PUT
                        </span>
                        <code class="text-blue-400 font-mono text-lg">/api/v1/users/{id}</code>
                    </div>
                    <p class="text-gray-400">Update existing user information with partial update support</p>
                    <div class="mt-4 text-xs text-gray-500 font-mono bg-gray-900/50 p-3 rounded-lg">
                        Supports partial updates
                    </div>
                </div>
                
                <div class="glass p-6 rounded-2xl hover:border-red-500 border-2 border-transparent transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="bg-red-500/20 text-red-400 px-4 py-2 rounded-lg text-sm font-bold border border-red-500/50">
                            DELETE
                        </span>
                        <code class="text-blue-400 font-mono text-lg">/api/v1/users/{id}</code>
                    </div>
                    <p class="text-gray-400">Soft delete user by ID with recovery option available</p>
                    <div class="mt-4 text-xs text-gray-500 font-mono bg-gray-900/50 p-3 rounded-lg">
                        Soft delete with restore API
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 px-4 relative">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-bold mb-6">
                    Simple <span class="bg-gradient-to-r from-green-400 to-blue-600 bg-clip-text text-transparent">Pricing</span>
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Choose the perfect plan for your needs. Start free, scale as you grow.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Free Plan -->
                <div class="glass p-8 rounded-3xl hover:scale-105 transition-all duration-300">
                    <div class="text-4xl mb-4">🎯</div>
                    <h3 class="text-3xl font-bold mb-2">Free</h3>
                    <div class="text-5xl font-bold mb-6">
                        $0
                        <span class="text-lg text-gray-400 font-normal">/month</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            1,000 requests/day
                        </li>
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            Basic support
                        </li>
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            Community access
                        </li>
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            Standard documentation
                        </li>
                    </ul>
                    <a href="#contact" class="block w-full text-center border-2 border-gray-700 py-4 rounded-xl font-bold hover:border-blue-500 hover:bg-blue-500/10 transition-all duration-300">
                        Get Started Free
                    </a>
                </div>
                
                <!-- Pro Plan - Popular -->
                <div class="gradient-border p-1 rounded-3xl hover:scale-105 transition-all duration-300 relative">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-2 rounded-full text-sm font-bold pulse-glow">
                        ⭐ Most Popular
                    </div>
                    <div class="bg-gray-900 p-8 rounded-3xl h-full">
                        <div class="text-4xl mb-4">🚀</div>
                        <h3 class="text-3xl font-bold mb-2">Pro</h3>
                        <div class="text-5xl font-bold mb-6">
                            <span class="bg-gradient-to-r from-blue-400 to-purple-600 bg-clip-text text-transparent">$29</span>
                            <span class="text-lg text-gray-400 font-normal">/month</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-300">
                                <span class="text-green-400 text-xl">✓</span>
                                100,000 requests/day
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <span class="text-green-400 text-xl">✓</span>
                                Priority support
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <span class="text-green-400 text-xl">✓</span>
                                Advanced analytics
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <span class="text-green-400 text-xl">✓</span>
                                Custom webhooks
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <span class="text-green-400 text-xl">✓</span>
                                Team collaboration
                            </li>
                        </ul>
                        <a href="#contact" class="block w-full text-center bg-gradient-to-r from-blue-500 to-purple-600 py-4 rounded-xl font-bold hover:scale-105 transition-transform pulse-glow">
                            Start Pro Trial
                        </a>
                    </div>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="glass p-8 rounded-3xl hover:scale-105 transition-all duration-300">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="text-3xl font-bold mb-2">Enterprise</h3>
                    <div class="text-5xl font-bold mb-6">
                        Custom
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            Unlimited requests
                        </li>
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            24/7 dedicated support
                        </li>
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            Custom integrations
                        </li>
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            99.99% SLA guarantee
                        </li>
                        <li class="flex items-center gap-3 text-gray-300">
                            <span class="text-green-400 text-xl">✓</span>
                            Private cloud option
                        </li>
                    </ul>
                    <a href="#contact" class="block w-full text-center border-2 border-gray-700 py-4 rounded-xl font-bold hover:border-purple-500 hover:bg-purple-500/10 transition-all duration-300">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 px-4 relative">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-bold mb-6">
                    Get in <span class="bg-gradient-to-r from-green-400 to-blue-600 bg-clip-text text-transparent">Touch</span>
                </h2>
                <p class="text-xl text-gray-400">
                    Have questions? We'd love to hear from you. Send us a message!
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- WhatsApp -->
                <a href="https://wa.me/6281515630449" target="_blank" class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 hover:border-green-500 border-2 border-transparent">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="text-5xl group-hover:scale-110 transition-transform">💬</div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-1">WhatsApp</h3>
                            <p class="text-gray-400">Chat with me directly</p>
                        </div>
                    </div>
                    <div class="text-green-400 font-mono text-lg">+62 815-1563-0449</div>
                    <div class="mt-4 text-sm text-gray-500">Click to start chatting →</div>
                </a>
                
                <!-- Email -->
                <a href="mailto:iqbal140605@gmail.com" class="group glass p-8 rounded-3xl hover:scale-105 transition-all duration-300 hover:border-blue-500 border-2 border-transparent">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="text-5xl group-hover:scale-110 transition-transform">📧</div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-1">Email</h3>
                            <p class="text-gray-400">Send me an email</p>
                        </div>
                    </div>
                    <div class="text-blue-400 font-mono text-lg break-all">iqbal140605@gmail.com</div>
                    <div class="mt-4 text-sm text-gray-500">Click to compose email →</div>
                </a>
            </div>
            
            <!-- CTA Banner -->
            <div class="gradient-border rounded-3xl p-1">
                <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-12 rounded-3xl text-center">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4">
                        Ready to Build Something Amazing?
                    </h3>
                    <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                        Join developers worldwide who trust IqbalDev API for their applications
                    </p>
                    <a href="https://wa.me/6281515630449?text=Hi%20Iqbal,%20I'm%20interested%20in%20using%20your%20API%20service!" target="_blank" class="inline-block bg-gradient-to-r from-green-500 via-blue-500 to-purple-600 px-12 py-5 rounded-2xl font-bold text-lg hover:scale-105 transition-all duration-300 pulse-glow">
                        Start Free Today 🚀
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-4 border-t border-gray-800/50 relative">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center font-bold text-xl">
                            I
                        </div>
                        <span class="text-xl font-bold">IqbalDev API</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Building the future of API services with performance, security, and simplicity.
                    </p>
                </div>
                
                <div>
                    <h5 class="font-bold mb-4 text-lg">Product</h5>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#features" class="hover:text-blue-400 transition-colors">Features</a></li>
                        <li><a href="#endpoints" class="hover:text-blue-400 transition-colors">API Docs</a></li>
                        <li><a href="#pricing" class="hover:text-blue-400 transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Changelog</a></li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="font-bold mb-4 text-lg">Resources</h5>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Documentation</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Tutorials</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Status</a></li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="font-bold mb-4 text-lg">Contact</h5>
                    <ul class="space-y-3 text-gray-400">
                        <li>
                            <a href="https://wa.me/6281515630449" target="_blank" class="hover:text-green-400 transition-colors flex items-center gap-2">
                                <span>💬</span> WhatsApp
                            </a>
                        </li>
                        <li>
                            <a href="mailto:iqbal140605@gmail.com" class="hover:text-blue-400 transition-colors flex items-center gap-2">
                                <span>📧</span> Email
                            </a>
                        </li>
                        <li><a href="#" class="hover:text-pink-400 transition-colors">Support Center</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800/50 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">
                    © 2026 IqbalDev API Service. All rights reserved.
                </p>
                <div class="flex gap-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-blue-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-400 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-blue-400 transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>