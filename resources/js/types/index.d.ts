import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Organization {
    id: number;
    name: string;
    description?: string;
    address?: string;
    street?: string;
    postcode?: string;
    city?: string;
    country?: string;
    logo?: string;
    phone?: string;
    website?: string;
    establishments: Establishment[]
}

export interface Establishment {
    id: number;
    name: string;
    description?: string;
    address?: string;
    street?: string;
    postcode?: string;
    city?: string;
    country?: string;
    logo?: string;
    phone?: string;
    website?: string;
    jobOffers?: JobOffer[]
}

export interface JobOffer {
    id: number;
    title: string;
    description: string;
    contract_type: string;
    start_date?: string; 
    end_date?: string; 
    working_hours?: string; 
    salary?: string; // 
    status: 'draft' | 'published' | 'archived'; 
    published_at: string | number; 
    establishment_id: number; 
}

export type BreadcrumbItemType = BreadcrumbItem;
