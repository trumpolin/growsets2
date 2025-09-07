"use client";
import ArticleFacet from "./ArticleFacet";
import { useSelection } from "@/components/SelectionProvider";
import { useQueryClient } from "@tanstack/react-query";

export default function CategoryFacet() {
  const { selections } = useSelection();
  const category = selections.category ?? "default";
  const queryClient = useQueryClient();

  return (
    <ArticleFacet
      category={category}
      selectionKey="category"
      title="Articles"
      queryKey={["categoryArticles", category]}
      onSelect={() =>
        queryClient.invalidateQueries({ queryKey: ["filterOptions"] })
      }
    />
  );
}
