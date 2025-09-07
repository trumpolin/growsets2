"use client";
import ArticleFacet from "./ArticleFacet";
import { useSelection } from "@/components/SelectionProvider";

export default function LedFacet() {
  const { selections } = useSelection();
  const growbox = selections.growbox;

  return (
    <ArticleFacet
      category="led"
      selectionKey="led"
      title="Grow-LED"
      queryKey={["ledArticles", growbox]}
      fetchArgs={[growbox]}
    />
  );
}
