"use client";
import { fetchCategoryArticles } from "@/lib/api";
import ArticleListItem from "@/components/ArticleListItem";
import FacetPanel from "@/components/FacetPanel";
import { useSelection } from "@/components/SelectionProvider";
import { useInfiniteQuery } from "@tanstack/react-query";

export default function LedFacet() {
  const { selections, setSelection } = useSelection();
  const growbox = selections.growbox;
  const selected = selections.led;

  const { data, fetchNextPage, hasNextPage, isFetchingNextPage } =
    useInfiniteQuery({
      queryKey: ["ledArticles", growbox],
      queryFn: ({ pageParam = 1, signal }) =>
        fetchCategoryArticles("led", pageParam, 10, signal, growbox),
      getNextPageParam: (lastPage) =>
        lastPage.page < lastPage.totalPages ? lastPage.page + 1 : undefined,
      initialPageParam: 1,
    });

  const articles = data?.pages.flatMap((p) => p.items) ?? [];

  return (
    <FacetPanel title="Grow-LED">
      <ul className="space-y-2">
        {articles.map((article) => (
          <ArticleListItem
            key={article.id}
            article={article}
            selected={article.id === selected}
            onToggle={(id) => setSelection("led", id === selected ? null : id)}
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
