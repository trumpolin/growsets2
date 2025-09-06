/* eslint-disable react-hooks/rules-of-hooks */
import useSWR from "swr";

const API_BASE = process.env.NEXT_PUBLIC_API_BASE || "";

const fetcher = (url: string) => fetch(url).then((res) => res.json());

export interface Article {
  id: string;
  title: string;
  description?: string;
}

export interface Pagination<T> {
  items: T[];
  page: number;
  totalPages: number;
}

export function fetchCategoryArticles(category: string, page = 1) {
  return useSWR<Pagination<Article>>(
    `${API_BASE}/categories/${category}/articles?page=${page}`,
    fetcher
  );
}

export function fetchArticle(id: string) {
  return useSWR<Article>(id ? `${API_BASE}/articles/${id}` : null, fetcher);
}

export interface FilterOption {
  value: string;
  label: string;
}

export function fetchFilterOptions(facet: string, page = 1) {
  return useSWR<Pagination<FilterOption>>(
    `${API_BASE}/filters/${facet}?page=${page}`,
    fetcher
  );
}
