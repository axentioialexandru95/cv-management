import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Head } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, Download, FileText, Github, Layout, List, Shield, Sparkles, Zap } from 'lucide-react';

export default function Welcome() {
    return (
        <>
            <Head title="CV Maker - Create Your Professional Resume">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
            </Head>

            <div className="min-h-screen bg-background">
                {/* Navigation */}
                <nav className="border-b border-border/40">
                    <div className="container mx-auto flex items-center justify-between px-6 py-5">
                        <motion.div initial={{ opacity: 0, x: -20 }} animate={{ opacity: 1, x: 0 }} className="flex items-center gap-2">
                            <img src="/logo.png" alt="CV Maker" width={100} height={100} />
                        </motion.div>

                        <div className="flex items-center gap-6">
                            <a href="/admin">
                                <Button variant="ghost" className="text-base text-muted-foreground hover:text-foreground">
                                    Dashboard
                                </Button>
                            </a>
                            <a href="https://github.com/axentioialexandru95/cv-management">
                                <Github className="h-5 w-5 text-foreground" />
                            </a>
                        </div>
                    </div>
                </nav>

                {/* Hero Section */}
                <section className="relative container mx-auto px-6 pt-20 pb-32 lg:pt-32 lg:pb-40">
                    {/* Decorative dots */}
                    <div className="absolute top-32 right-20 h-3 w-3 rounded-full bg-primary/30" />
                    <div className="absolute top-48 right-32 h-2 w-2 rounded-full bg-primary/40" />
                    <div className="absolute bottom-20 left-40 h-3 w-3 rounded-full bg-primary/20" />

                    <div className="grid items-center gap-12 lg:grid-cols-2">
                        <div className="relative">
                            {/* Sparkle decoration */}
                            <motion.div
                                animate={{ rotate: [0, 10, 0], scale: [1, 1.1, 1] }}
                                transition={{ duration: 3, repeat: Infinity }}
                                className="absolute -top-8 -left-4"
                            >
                                <Sparkles className="h-6 w-6 text-foreground" />
                            </motion.div>

                            <motion.p
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: 0.2 }}
                                className="mb-4 text-3xl font-medium text-primary italic md:text-4xl"
                            >
                                Professional
                            </motion.p>

                            <motion.h1
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: 0.3 }}
                                className="mb-6 text-6xl leading-tight font-bold text-foreground md:text-7xl lg:text-8xl"
                            >
                                Resume <br />
                                Builder<span className="text-primary">.</span>
                            </motion.h1>

                            <motion.p
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: 0.4 }}
                                className="mb-8 max-w-lg text-lg leading-relaxed text-muted-foreground md:text-xl"
                            >
                                Create stunning, professional resumes in minutes. Choose from beautiful templates and land your dream job.
                            </motion.p>

                            {/* Hand-drawn arrow */}
                            <motion.svg
                                initial={{ opacity: 0 }}
                                animate={{ opacity: 1 }}
                                transition={{ delay: 0.8 }}
                                className="absolute -bottom-12 left-8 h-16 w-24 text-foreground"
                                viewBox="0 0 100 60"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                strokeLinecap="round"
                            >
                                <path d="M 10 30 Q 30 10, 50 30 T 90 30" />
                                <path d="M 85 25 L 90 30 L 85 35" />
                            </motion.svg>
                        </div>

                        <motion.div
                            initial={{ opacity: 0, scale: 0.9 }}
                            animate={{ opacity: 1, scale: 1 }}
                            transition={{ delay: 0.6 }}
                            className="relative"
                        >
                            {/* Icon-based CV illustration */}
                            <div className="relative rounded-3xl bg-card p-8 shadow-2xl">
                                <div className="mb-6 flex items-center gap-4">
                                    <div className="flex h-16 w-16 items-center justify-center rounded-full bg-primary/20">
                                        <FileText className="h-8 w-8 text-primary" />
                                    </div>
                                    <div className="flex-1 space-y-2">
                                        <div className="h-4 w-32 rounded-full bg-foreground/10" />
                                        <div className="h-3 w-24 rounded-full bg-foreground/10" />
                                    </div>
                                </div>
                                <div className="space-y-4">
                                    <div className="h-3 w-full rounded-full bg-foreground/10" />
                                    <div className="h-3 w-5/6 rounded-full bg-foreground/10" />
                                    <div className="h-3 w-4/6 rounded-full bg-foreground/10" />
                                </div>
                                <div className="mt-6 space-y-3">
                                    <div className="h-3 w-full rounded-full bg-foreground/10" />
                                    <div className="h-3 w-full rounded-full bg-foreground/10" />
                                    <div className="h-3 w-3/4 rounded-full bg-foreground/10" />
                                </div>
                                <div className="absolute -right-4 -bottom-4 h-24 w-24 rounded-full bg-primary/10 blur-2xl" />
                            </div>

                            {/* Decorative squiggle */}
                            <motion.svg
                                animate={{ rotate: [0, 5, 0] }}
                                transition={{ duration: 4, repeat: Infinity }}
                                className="absolute -top-8 -right-8 h-20 w-20 text-primary"
                                viewBox="0 0 100 100"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="3"
                                strokeLinecap="round"
                            >
                                <path d="M 20 50 Q 35 20, 50 50 T 80 50" />
                            </motion.svg>
                        </motion.div>
                    </div>
                </section>

                {/* Open Source Section */}
                <section className="container mx-auto px-6 py-16">
                    <motion.div
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="relative overflow-hidden rounded-2xl border-2 border-primary/20 bg-card/50 p-8 text-center lg:p-12"
                    >
                        <div className="absolute top-0 left-0 h-full w-1 bg-primary" />

                        <motion.div
                            initial={{ scale: 0 }}
                            whileInView={{ scale: 1 }}
                            viewport={{ once: true }}
                            transition={{ delay: 0.2, type: 'spring' }}
                            className="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-primary/20"
                        >
                            <a href="https://github.com/axentioialexandru95/cv-management">
                                <Github className="h-8 w-8 text-primary" />
                            </a>
                        </motion.div>

                        <h2 className="mb-4 text-3xl font-bold text-foreground lg:text-4xl">Open Source & Self-Hostable</h2>
                        <p className="mx-auto mb-6 max-w-2xl text-lg leading-relaxed text-muted-foreground">
                            This project is completely open source and free to use. Host it on your own server and have full control over your data
                            and infrastructure.
                        </p>
                        <a href="https://github.com/axentioialexandru95/cv-management" target="_blank" rel="noopener noreferrer">
                            <Button
                                variant="outline"
                                size="lg"
                                className="group rounded-xl border-2 border-primary/40 px-6 py-5 text-base font-semibold text-foreground hover:border-primary hover:bg-primary/10"
                            >
                                <Github className="mr-2 h-5 w-5" />
                                View on GitHub
                                <ArrowRight className="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
                            </Button>
                        </a>
                    </motion.div>
                </section>

                {/* Features Section */}
                <section className="relative container mx-auto px-6 py-20">
                    {/* Decorative squiggle */}
                    <motion.svg
                        animate={{ rotate: [0, -10, 0] }}
                        transition={{ duration: 5, repeat: Infinity }}
                        className="absolute -top-4 right-32 h-16 w-16 text-primary"
                        viewBox="0 0 100 100"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="3"
                        strokeLinecap="round"
                    >
                        <path d="M 30 70 L 40 30 M 35 35 L 40 30 L 45 35" />
                    </motion.svg>

                    <motion.div
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="relative overflow-hidden rounded-3xl bg-secondary p-12 shadow-2xl lg:p-16"
                    >
                        {/* Teal accent border */}
                        <div className="absolute inset-y-0 left-0 w-2 bg-primary" />
                        <div className="absolute inset-x-0 bottom-0 h-2 bg-primary" />

                        <div className="relative">
                            <div className="mb-12 flex items-center gap-4">
                                <Zap className="h-10 w-10 text-primary" />
                                <h2 className="text-4xl font-bold text-foreground lg:text-5xl">Features Included</h2>
                            </div>

                            <p className="mb-12 max-w-3xl text-lg text-muted-foreground">
                                Everything you need to create professional resumes that get you hired
                            </p>

                            <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                                {[
                                    {
                                        icon: FileText,
                                        title: 'Europass Format',
                                        description: 'Generate professional CVs in the widely-recognized Europass standard format.',
                                    },
                                    {
                                        icon: Layout,
                                        title: 'Structured Builder',
                                        description: 'Comprehensive form-based interface for building detailed CVs through the admin panel.',
                                    },
                                    {
                                        icon: List,
                                        title: 'Complete Sections',
                                        description:
                                            'Add work experience, education, languages, skills, certifications, projects, publications, and volunteer work.',
                                    },
                                    {
                                        icon: Download,
                                        title: 'PDF Export',
                                        description: 'Download your professionally formatted CV as a high-quality PDF document.',
                                    },
                                    {
                                        icon: Shield,
                                        title: 'Secure & Private',
                                        description: 'Your CVs are private and accessible only to you through secure authentication.',
                                    },
                                    {
                                        icon: Zap,
                                        title: 'Admin Dashboard',
                                        description: 'Full-featured admin panel built with Filament for easy CV creation and management.',
                                    },
                                ].map((feature, index) => (
                                    <motion.div
                                        key={feature.title}
                                        initial={{ opacity: 0, y: 20 }}
                                        whileInView={{ opacity: 1, y: 0 }}
                                        viewport={{ once: true }}
                                        transition={{ delay: index * 0.1 }}
                                        className="group"
                                    >
                                        <div className="mb-4 flex items-center gap-4">
                                            <div className="rounded-2xl bg-primary/10 p-3">
                                                <feature.icon className="h-6 w-6 text-primary" />
                                            </div>
                                            {feature.badge && (
                                                <Badge className="bg-primary/90 text-xs font-semibold text-primary-foreground hover:bg-primary">
                                                    {feature.badge}
                                                </Badge>
                                            )}
                                        </div>
                                        <h3 className="mb-2 text-xl font-semibold text-foreground">{feature.title}</h3>
                                        <p className="text-base leading-relaxed text-muted-foreground">{feature.description}</p>
                                    </motion.div>
                                ))}
                            </div>
                        </div>
                    </motion.div>

                    {/* Decorative doodle outside the card */}
                    <motion.svg
                        animate={{ rotate: [0, 360] }}
                        transition={{ duration: 20, repeat: Infinity, ease: 'linear' }}
                        className="absolute -bottom-8 -left-8 h-20 w-20 text-foreground"
                        viewBox="0 0 100 100"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="2"
                        strokeLinecap="round"
                    >
                        <path d="M 30 50 L 70 50 M 50 30 L 50 70" />
                    </motion.svg>
                </section>

                {/* CTA Section */}
                <section className="container mx-auto px-6 py-32">
                    <motion.div initial={{ opacity: 0, y: 20 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} className="text-center">
                        <h2 className="mb-4 text-5xl font-bold text-foreground lg:text-6xl">Ready to Get Started?</h2>
                        <p className="mx-auto mb-8 max-w-2xl text-lg text-muted-foreground">
                            Join thousands of professionals who've created their perfect resume with CV Maker
                        </p>
                        <a href="/admin/register">
                            <Button size="lg" className="group rounded-xl px-10 py-7 text-lg font-semibold shadow-xl transition-all hover:shadow-2xl">
                                Create Your Resume Now
                                <ArrowRight className="ml-2 h-5 w-5 transition-transform group-hover:translate-x-1" />
                            </Button>
                        </a>
                    </motion.div>
                </section>

                {/* Footer */}
                <footer className="border-t border-border/40 py-12">
                    <div className="container mx-auto px-6 text-center">
                        <p className="text-sm text-muted-foreground">
                            &copy; {new Date().getFullYear()}{' '}
                            <a href="http://phantomtechind.com/" target="_blank" rel="noopener noreferrer" className="text-primary hover:underline">
                                Phantom Tech
                            </a>
                            . All rights reserved.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}
