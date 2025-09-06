"use client";
import { fetchCategoryArticles } from "@/lib/api";
import ArticleListItem from "@/components/ArticleListItem";
import FacetPanel from "@/components/FacetPanel";
import { useSelection } from "@/components/SelectionProvider";
import { useInfiniteQuery } from "@tanstack/react-query";

export default function FanFacet() {
  const { selections, setSelection } = useSelection();
  const selected = selections.fan;

  const { data, fetchNextPage, hasNextPage, isFetchingNextPage } =
    useInfiniteQuery({
      queryKey: ["fanArticles"],
      queryFn: ({ pageParam = 1, signal }) =>
        fetchCategoryArticles("fan", pageParam, 10, signal),
      getNextPageParam: (lastPage) =>
        lastPage.page < lastPage.totalPages ? lastPage.page + 1 : undefined,
      initialPageParam: 1,
    });

  const articles = data?.pages.flatMap((p) => p.items) ?? [];

  return (
    <FacetPanel title="Lüfter">
      <ul className="space-y-2">
        {articles.map((article) => (
          <ArticleListItem
            key={article.id}
            article={article}
            selected={article.id === selected}
            onToggle={(id) => setSelection("fan", id === selected ? null : id)}
          />
        ))}
      </ul>
      {hasNextPage && (
        <button
          className="mt-2 rounded bg-gray-200 px-3 py-1"
          onClick={() => fetchNextPage()}
          disabled={isFetchingNextPage}
        >
          {isFetchingNextPage ? "Loading..." : "Load more"}
        </button>
      )}
    </FacetPanel>
  );
}
