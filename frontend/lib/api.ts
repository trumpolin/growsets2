const API_BASE = process.env.NEXT_PUBLIC_API_BASE || "";

export interface Article {
  id: string;
  title: string;
  description?: string;
  image?: string;
  price?: number;
}

export interface Pagination<T> {
  items: T[];
  page: number;
  totalPages: number;
}

export async function fetchCategoryArticles(
  category: string,
  page = 1,
  limit = 10,
  signal?: AbortSignal,
  relatedId?: string,
): Promise<Pagination<Article>> {
  const params = new URLSearchParams({
    page: String(page),
    limit: String(limit),
  });
  if (relatedId) params.set("related", relatedId);
  const url = `${API_BASE}/categories/${category}/articles?${params.toString()}`;
  const res = await fetch(url, { signal });
  if (!res.ok) throw new Error("Failed to fetch category articles");
  return res.json();
}

export async function fetchArticle(
  id: string,
  signal?: AbortSignal,
): Promise<Article> {
  const res = await fetch(`${API_BASE}/articles/${id}`, { signal });
  if (!res.ok) throw new Error("Failed to fetch article");
  return res.json();
}

export interface FilterOption {
  value: string;
  label: string;
}

export async function fetchFilterOptions(
  facet: string,
  page = 1,
  limit = 10,
  signal?: AbortSignal,
): Promise<Pagination<FilterOption>> {
  const res = await fetch(
    `${API_BASE}/filters/${facet}?page=${page}&limit=${limit}`,
    { signal },
  );
  if (!res.ok) throw new Error("Failed to fetch filter options");
  return res.json();
}
